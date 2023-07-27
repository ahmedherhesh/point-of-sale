<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    function index(){
        $categories = Category::get();
        $companies = Company::get();
        $items = Item::get();
        return inertia('Pos',compact('categories','companies','items'));
    }
}
