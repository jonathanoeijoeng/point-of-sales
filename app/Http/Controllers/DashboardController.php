<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\FoodDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function get10MostSoldProducts()
    {
        return Cart::with('food_detail')
            ->select('id', 'food_detail_id', DB::raw('sum(quantity) as qty'), DB::raw('sum(after_disc) as net_revenue'), DB::raw('sum(sub_total) as gross_revenue'),)
            ->groupBy('food_detail_id')
            ->where('is_checkout', true)
            ->orderby('net_revenue', 'desc')
            ->limit(10)
            ->get();
    }

    public function index()
    {
        $foods = $this->get10MostSoldProducts();

        // This month data
        $daily = Cart::with('food_detail')
            ->select('food_detail_id', DB::raw('sum(quantity) as qty'), DB::raw('sum(after_disc) as net_revenue'), DB::raw('sum(sub_total) as gross_revenue'), DB::raw('DATE_FORMAT(updated_at, "%d") as date'))
            ->groupBy('date')
            ->where('is_checkout', true)
            ->whereMonth('updated_at', date('m'))
            ->orderby('date')
            ->get();
        $monthly = Cart::with('food_detail')
            ->select('food_detail_id', DB::raw('sum(quantity) as qty'), DB::raw('sum(after_disc) as net_revenue'), DB::raw('sum(sub_total) as gross_revenue'), DB::raw('DATE_FORMAT(updated_at, "%b") as month'))
            ->groupBy('month')
            ->where('is_checkout', true)
            ->whereYear('updated_at', date('Y'))
            ->orderby('updated_at')
            ->get();

        $date = [];
        foreach ($daily as $key => $value) {
            $date[] = $value->date;
        }

        $net_revenue = [];
        foreach ($daily as $key => $value) {
            $net_revenue[] = $value->net_revenue;
        }

        $month = [];
        foreach ($monthly as $key => $value) {
            $month[] = $value->month;
        }

        $net_revenue_month = [];
        foreach ($monthly as $key => $value) {
            $net_revenue_month[] = $value->net_revenue;
        }

        return inertia('Dashboard/Index', [
            'foods' => $foods,
            'date' => $date,
            'net_revenue' => $net_revenue,
            'month' => $month,
            'net_revenue_month' => $net_revenue_month,
        ]);
    }

    public function addToFavorites()
    {
        $favorite = $this->get10MostSoldProducts();

        $ids = [];
        foreach ($favorite as $key => $value) {
            $ids[] = $value->food_detail_id;
        }

        DB::beginTransaction();
        $foods = FoodDetail::all();
        foreach ($foods as $food) {
            $id = $food->id;
            FoodDetail::where('id', $id)->update(['is_favorite' => false]);
        }
        foreach ($ids as $id) {
            FoodDetail::where('id', $id)->update(['is_favorite' => true]);
        }
        DB::commit();

        return redirect()->route('dashboard')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'text' => 'Successfully added to favorites',
                'type' => 'success',
            ]
        ]);
    }
}
