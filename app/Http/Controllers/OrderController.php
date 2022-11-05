<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Table;
use App\Models\Category;
use App\Models\FoodDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // $quote = Http::get('https://api.quotable.io/random')->json()['content'];
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
            $duplicate->save();
        } else {
            Cart::create([
                'food_detail_id' => $request->data['id'],
                'quantity' => 1,
                'is_checkout' => false,
                'sub_total' => $food->price,
                'after_disc' => $food->price,
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
                'after_disc' => $price * $request->data['quantity'],
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
            'after_disc' => $cart->quantity * $cart->food_detail->price * (1 - $request->data['discount'] / 100),
        ]);
    }

    public function checkout(Request $request)
    {
        $carts = Cart::where('table_id', $request->data['table_id'])
            ->where('is_checkout', false)
            ->get();
        $invoice_no = 'INV-' . date('Ymd') . '-' . str_pad(Cart::whereDate('created_at', date('Y-m-d'))->count() + 1, 3, '0', STR_PAD_LEFT);

        foreach ($carts as $cart) {
            $cart->update([
                'is_checkout' => true,
                'invoice_no' => $invoice_no,
            ]);
        }

        return redirect()->route('order', ['table_id' => $request->data['table_id']])->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'Checkout success! <br>Invoce No: ' . $invoice_no,
                'type' => 'success',
            ],
        ]);
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
    }

    public function process(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->update([
            'is_processed' => true,
            'time_processed' => now(),
        ]);

        return redirect()->route('kitchen')->with([
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

        return redirect()->route('kitchen')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'Order done!',
                'type' => 'success',
                'toast' => true,
            ],
        ]);
    }
}
