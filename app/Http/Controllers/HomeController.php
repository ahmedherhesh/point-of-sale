<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Item;
use App\Models\ItemReturn;
use Illuminate\Http\Request;

class HomeController extends MasterController
{
    function profits($deliveries){
        $profits = 0;
        foreach($deliveries->get() as $delivery){
            $returnedQty = 0;
            foreach($delivery->itemReturn as $itemReturn){
                $returnedQty += $itemReturn->qty;
            }
            $profits += ($delivery->price_of_sale - $delivery->price) * ($delivery->qty - $returnedQty);
        }
        return $profits;

    }

    function index()
    {
        return inertia('Home');
    }
}
