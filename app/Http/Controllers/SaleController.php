<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\OperationsResource;
use App\Http\Resources\SalesResource;
use App\Models\Item;
use App\Models\Operation;
use App\Models\Sale;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;

class SaleController extends MasterController
{
    function makeSale($request, $operation)
    {
        $price = 0;
        $sale_price = 0;
        $sales = [];
        foreach ($request->items as $key => $ordered_item) {
            $item = Item::find($ordered_item['id']);
            if ($item->stock >= $ordered_item['qty']) {
                $qty = (float)($ordered_item['qty']);
                $sales[] = [
                    'item_id' => $item->id,
                    'operation_id' => $operation->id,
                    'status' => $item->status,
                    'price' => $item->price,
                    'sale_price' => $item->sale_price,
                    'qty' => $ordered_item['qty'],
                ];
                $price += ((float)$item->price * $qty);
                $sale_price += ((float)$item->sale_price * $qty);
                $item->update(['stock' => (float)$item->stock - $qty]);
            }
        }
        $operation->update(['price' => $price, 'sale_price' => $sale_price]);
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
        $request->validate(['invoice_id' => 'nullable|exists:operations,id']);
        $operation = Operation::query();
        if ($request->invoice_id)
            $operation = $operation->whereId($request->invoice_id)->paginate(1);
        else
            $operation = $operation->paginate(50);
        $operations = SalesResource::collection($operation);
        return inertia('Sales/Sales', compact('operations'));
    }
    function pos()
    {
        return inertia('Sales/Create', $this->data);
    }
    function store(SaleRequest $request)
    {
        $data = $request->except('items');
        $data['user_id'] = $this->user()->id;
        $new_operation = Operation::create($data);
        $makeSale = $this->makeSale($request, $new_operation);
        if ($makeSale)
            return response()->json(['invoice_id'  => $new_operation->id]);
    }

    function show($id)
    {
        $operation = Operation::findOrFail($id);
        $invoice =  new OperationsResource($operation);
        $zeros = '';
        if (strlen($invoice->id) < 3)
            $zeros = '00';
        $barcode = DNS1D::getBarcodeHTML($zeros . $invoice->id, 'CODABAR', 1.5, 40) . '#' . $zeros . '-' . $invoice->id;
        return inertia('Sales/Invoice', compact('invoice', 'barcode'));
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
        $makeSale = $this->makeSale($request, $operation);
        if ($makeSale)
            return response()->json(['invoice_id'  => $operation->id]);
    }

    function destroy(Operation $operation)
    {
        $this->destroySale($operation);
        $operation->delete();
    }
}
