<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use App\Models\Operation;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends MasterController
{
    function index()
    {
        $categories = Category::latest()->get();
        $companies = Company::latest()->get();
        $items = ItemsResource::collection(Item::inStock()->latest()->paginate(100));
        return inertia('Pos', compact('categories', 'companies', 'items'));
    }
    function itemsFilter(Request $request)
    {
        $request->validate(['code' => 'nullable|exists:items,code']);
        $items = Item::inStock();
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
    function sale(SaleRequest $request)
    {
        $data = $request->except('items');
        $new_operation = Operation::create($data);
        $sales = [];
        foreach ($request->items as $ordered_item) {
            $item = Item::find($ordered_item['id']);
            if ($item->stock >= $ordered_item['qty']) {
                $sales[] = [
                    'user_id' => $this->user()->id,
                    'item_id' => $item->id,
                    'operation_id' => $new_operation->id,
                    'status' => $item->status,
                    'price' => $item->price,
                    'sale_price' => $item->sale_price,
                    'qty' => $ordered_item['qty'],
                ];
                $item->update(['stock' => (float)$item->stock -  (float)($ordered_item['qty'])]);
            }
        }
        $sale = $sales ? Sale::insert($sales) : null;
        if ($sale)
            redirect()->back();
    }
}
