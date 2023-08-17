<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    function profits($sales)
    {
        $profits = 0;
        foreach ($sales->get() as $sale) {
            $profits += $sale->price_of_sale - $sale->price * $sale->qty;
        }
        return $profits;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Profits');
    }
}
