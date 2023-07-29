<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
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

        $items = $items->get(['id', 'title', 'price', 'stock', 'image']);
        return response()->json($items);
    }
}
