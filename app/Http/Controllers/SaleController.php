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
    public $permission = 'المبيعات';

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
        $operations = Operation::has('sales')->latest();

        if (empty($request->all()))
            $operations = $operations->whereYear('created_at', now()->y)->whereMonth('created_at', now()->month);

        if ($request->from)
            $operations = $operations->whereDate('created_at', '>=', $request->from);

        if ($request->to)
            $operations = $operations->whereDate('created_at', '<=', $request->to);

        if ($request->invoice_id)
            $operations = $operations->whereId($request->invoice_id)->paginate(1);
        else
            $operations = $operations->paginate(50);
        
        $operations = SalesResource::collection($operations);
        return inertia('Sales/Sales', compact('operations'));
    }
    function create()
    {
        return inertia('Sales/Create', $this->data());
    }
    function store(SaleRequest $request)
    {
        $data = $request->except('items');
        $data['user_id'] = $this->user()->id;
        $new_operation = Operation::create($data);
        $makeSale = $this->makeSale($request, $new_operation);
        if ($makeSale)
            return redirect()->back()->with('operation_id', $new_operation->id);
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
        $data = $this->data();
        $data['operation'] = (new OperationsResource(Operation::findOrFail($id)));
        return inertia('Sales/Edit', $data);
    }

    function update(SaleRequest $request, $id)
    {
        $operation = Operation::findOrFail($id);
        $data = $request->except('items');
        $this->destroySale($operation);
        $operation->update($data);
        $makeSale = $this->makeSale($request, $operation);
        if ($makeSale)
            return redirect()->back()->with('operation_id', $operation->id);
    }

    function destroy($id)
    {
        $operation = Operation::findOrFail($id);
        $this->destroySale($operation);
        $operation->delete();
    }
}
