<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\ItemsResource;
use App\Http\Resources\OperationsResource;
use App\Http\Resources\SalesResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use App\Models\Operation;
use App\Models\Sale;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Operator;

class SaleController extends MasterController
{
    public $data;
    function __construct()
    {
        $this->data = [
            'categories' => Category::latest()->get(),
            'companies' => Company::latest()->get(),
            'items' => ItemsResource::collection(Item::inStock()->latest()->paginate(100)),
        ];
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
    function makeSale($request, $operation)
    {
        $sales = [];
        foreach ($request->items as $ordered_item) {
            $item = Item::find($ordered_item['id']);
            if ($item->stock >= $ordered_item['qty']) {
                $sales[] = [
                    'user_id' => $this->user()->id,
                    'item_id' => $item->id,
                    'operation_id' => $operation->id,
                    'status' => $item->status,
                    'price' => $item->price,
                    'sale_price' => $item->sale_price,
                    'qty' => $ordered_item['qty'],
                ];
                $item->update(['stock' => (float)$item->stock -  (float)($ordered_item['qty'])]);
            }
        }
        return $sales ? Sale::insert($sales) : null;
    }
    function destroySale($operation)
    {
        foreach ($operation->sales as $sale) {
            $item = $sale->item;
            $item->update(['stock' => $item->stock + $sale->qty]);
            $sale->delete();
        }
        return true;
    }
    function index(Request $request)
    {
        $operations = SalesResource::collection(Operation::paginate(50));
        return inertia('Sales/Sales', ['operations' => $operations]);
    }
    function pos()
    {
        return inertia('Sales/Create', $this->data);
    }
    function store(SaleRequest $request)
    {
        $data = $request->except('items');
        $new_operation = Operation::create($data);
        $this->makeSale($request, $new_operation);
    }

    function show($id)
    {
    }

    function edit($id)
    {
        $this->data['operation'] = (new OperationsResource(Operation::findOrFail($id)));
        return inertia('Sales/Edit', $this->data);
    }

    function update(SaleRequest $request, $id)
    {
        $operation = Operation::findOrFail($id);
        $data = $request->except('items');
        $this->destroySale($operation);
        $operation->update($data);
        $this->makeSale($request, $operation);
        return redirect()->back();
    }

    function destroy(Operation $operation)
    {
        $this->destroySale($operation);
        $operation->delete();
    }
}
