<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Midtrans\Config;
use App\Models\Table;
use App\Models\Category;
use App\Events\OrderDone;
use App\Events\OrderSent;
use App\Models\FoodDetail;
use Illuminate\Http\Request;
use App\Events\OrderProcessed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class OrderController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        $orders = Cart::where('is_checkout', 0)->groupBy('table_id')->pluck('table_id')->toArray();
        $carts = DB::table('carts')->where('is_checkout', 0)->selectRaw('table_id, sum(after_disc) as total')->groupBy('table_id')->get();

        return inertia('Tables', [
            'tables' => $tables,
            'orders' => $orders,
            'carts' => $carts,
        ]);
    }

    public function order(Request $request)
    {
        // dd($request['table_id']);
        $foods = FoodDetail::query()
            ->when($request->filters['search'] ?? null, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->filters['category'] ?? null, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->where('is_available', 1)
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();
        $carts = Cart::with('food_detail')
            ->when($request['table_id'] ?? null, function ($query, $table_id) {
                return $query->where('table_id', $table_id);
            })
            ->where('is_checkout', false)
            ->get();

        return inertia('Order', [
            'foods' => $foods,
            'categories' => $categories,
            'carts' => $carts,
            'table_id' => $request['table_id'],
        ]);
    }

    public function add(Request $request)
    {
        $food = FoodDetail::find($request->data['id']);

        $duplicate = Cart::where('user_id', Auth::user()->id)
            ->where('food_detail_id', $request->data['id'])
            ->where('table_id', $request->data['table_id'])
            ->where('is_sent_to_kitchen', false)
            ->where('is_processed', false)
            ->where('is_checkout', false)
            ->where('is_done', false)
            ->first();

        if ($duplicate) {
            $duplicate->quantity++;
            $duplicate->sub_total = $duplicate->quantity * $duplicate->price;
            $duplicate->after_disc = $duplicate->sub_total - $duplicate->discount_value;
            $duplicate->tax = $duplicate->after_disc * 0.1;
            $duplicate->total = $duplicate->after_disc * 1.1;
            $duplicate->save();
        } else {
            Cart::create([
                'food_detail_id' => $request->data['id'],
                'quantity' => 1,
                'price' => $food->price,
                'is_checkout' => false,
                'sub_total' => $food->price,
                'after_disc' => $food->price,
                'tax' => $food->price * 0.1,
                'total' => $food->price * 1.1,
                'table_id' => $request->data['table_id'],
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function change(Request $request)
    {
        $cart = Cart::find($request->data['id']);
        $price = $cart->food_detail->price;

        if ($request->data['quantity'] > 0) {
            $cart->update([
                'quantity' => $request->data['quantity'],
                'sub_total' => $price * $request->data['quantity'],
                'after_disc' => $price - $cart->discount_value,
                'tax' => $price * $request->data['quantity'] * 0.1,
                'total' => $price * $request->data['quantity'] * 1.1,
            ]);
        } else {
            $cart->delete();
        }
    }

    public function note(Request $request)
    {
        // dd($request->all());
        $cart = Cart::find($request->data['id']);

        $cart->update([
            'notes' => $request->data['notes'],
            'discount' => $request->data['discount'],
            'discount_value' => $request->data['discount'] * $cart->price * $cart->quantity / 100,
            'after_disc' => $cart->quantity * $cart->food_detail->price * (1 - $request->data['discount'] / 100),
            'tax' => $cart->quantity * $cart->food_detail->price * (1 - $request->data['discount'] / 100) * 0.1,
            'total' => $cart->quantity * $cart->food_detail->price * (1 - $request->data['discount'] / 100) * 1.1,
        ]);
    }

    public function checkout(Request $request)
    {
        $carts = Cart::with('food_detail', 'table')
            ->where('table_id', $request->data['table_id'])
            ->where('is_checkout', false)
            ->get();
        $invoice_no = 'INV-' . date('Ymd-his') . '-' . str_pad(Cart::whereDate('created_at', date('Y-m-d'))->count() + 1, 3, '0', STR_PAD_LEFT);

        foreach ($carts as $cart) {
            $cart->update([
                'is_checkout' => true,
                'invoice_no' => $invoice_no,
                'time_checkout' => now(),
            ]);
        }

        $invoice = Cart::with('table')->where('invoice_no', $invoice_no)->first();

        // Midtrans

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-hl5YDnnLwRZiJls3sE70TmdW';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $invoice_no,
                'gross_amount' => $invoice->total,
            ),
            'customer_details' => array(
                'table' => $request->data['table_id'],
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return inertia('Checkout', [
            'carts' => $carts,
            'table_id' => $request->data['table_id'],
            'invoice' => $invoice,
            'snapToken' => $snapToken,
        ]);
    }

    public function checkout_success(Request $request)
    {
        $data = $request->all();
        $invoice = Cart::with('table')->where('invoice_no', $data['order_id'])->first();
        $invoice->is_paid = true;
        $invoice->time_paid = now();
        $invoice->save();

        return inertia('Tables');
    }

    public function kitchen()
    {
        $orders = Cart::with('food_detail', 'table')
            ->where('is_sent_to_kitchen', true)
            ->where('is_checkout', false)
            ->where('is_done', false)
            ->orderBy('time_sent_to_kitchen')
            ->get();

        return inertia('Kitchen', [
            'orders' => $orders,
        ]);
    }

    public function sent_to_kitchen(Request $request)
    {
        $carts = Cart::where('table_id', $request->data['table_id'])
            ->where('is_checkout', false)
            ->where('is_sent_to_kitchen', false)
            ->get();

        foreach ($carts as $cart) {
            $cart->update([
                'is_sent_to_kitchen' => true,
                'time_sent_to_kitchen' => now(),
            ]);
        }

        $orders = Cart::with('food_detail', 'table')
            ->where('is_sent_to_kitchen', true)
            ->where('is_checkout', false)
            ->where('is_done', false)
            ->orderBy('time_sent_to_kitchen')
            ->get();

        broadcast(new OrderSent($orders));
    }

    public function process(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->update([
            'is_processed' => true,
            'time_processed' => now(),
        ]);

        broadcast(new OrderProcessed($cart));

        return redirect()->route('kitchen', ['table_id' => $request->table_id])->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'Order <b>' . $request->food_detail['name'] . '</b> processed!',
                'type' => 'success',
                'toast' => true,
            ],
        ]);
    }

    public function done(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->update([
            'is_done' => true,
            'time_done' => now(),
        ]);

        broadcast(new OrderDone($cart));

        return redirect()->route('kitchen', ['table_id' => $request->table_id])->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'Order done!',
                'type' => 'success',
                'toast' => true,
            ],
        ]);
    }

    public function invoice(Request $request)
    {
        $invoices = Cart::with('table')
            ->select('invoice_no', 'table_id', DB::raw('sum(total) as total'))
            ->where('is_checkout', true)
            // ->where('invoice_no', 'like', '%' . $request->data['invoice_no'] . '%')
            ->orderBy('created_at', 'desc')
            ->groupBy('invoice_no')
            ->get();

        if ($request->invoice_no) {
            $details = Cart::with('food_detail', 'table')
                ->where('invoice_no', 'like', '%' . $request->invoice_no . '%')
                ->get();
            $invoice = Cart::with('table')
                ->select('invoice_no', 'table_id', DB::raw('sum(sub_total) as sub_total'), DB::raw('sum(discount_value) as discount'), DB::raw('sum(after_disc) as after_disc'), DB::raw('sum(after_disc) as after_disc'), DB::raw('sum(tax) as tax'), DB::raw('sum(total) as total'))
                ->where('invoice_no', 'like', '%' . $request->invoice_no . '%')
                ->first();
        } else {
            $details = null;
            $invoice = null;
        }

        return inertia('Invoice', [
            'invoices' => $invoices,
            'details' => $details,
            'invoice_detail' => $invoice,
        ]);
    }
}
