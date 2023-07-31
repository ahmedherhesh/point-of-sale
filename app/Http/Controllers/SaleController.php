<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    function index()
    {
        $categories = Category::get();
        $companies = Company::get();
        $items = ItemsResource::collection(Item::latest()->paginate(100));
        return inertia('Pos', compact('categories', 'companies', 'items'));
    }
    //pos
    function itemsFilter(Request $request)
    {
        $request->validate(['code' => 'nullable|exists:items,code']);
        $items = Item::query();
        if ($request->code) {
            $items->whereCode($request->code);
        } else {
            if ($request->title)
                $items->where('title', 'LIKE', "%$request->title%");
            if ($request->cat_id)
                $items->whereCatId($request->cat_id);
            if ($request->company_id)
                $items->whereCompanyId($request->company_id);
        }
        $items = $items->latest()->paginate(100);

        return response()->json($items);
    }
}
