<?php

namespace App\Http\Controllers;

use App\Http\Requests\DamageItemsRequest;
use App\Models\DamageItem;
use App\Models\Item;
use App\Http\Resources\DemageItemResource;

class DamageItemController extends MasterController
{
    public $permission = 'المنتجات التالفة';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $damageItems = DemageItemResource::collection(DamageItem::with('item')->has('item')->latest()->paginate(50)) ;
        return inertia('Damages/Damages', compact('damageItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Damages/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DamageItemsRequest $request)
    {
        $item = Item::whereCode($request->code)->first();
        if ($item->stock < $request->stock)
            return redirect()->back();
        $damageItem = DamageItem::whereCode($request->code)->first();
        if ($damageItem)
            return redirect()->route('damages.edit', $damageItem->id);
        else {
            $damageItem = DamageItem::create($request->all());
            if ($damageItem)
                $item->update(['stock' => $item->stock - $damageItem->stock]);
        }
    }
    public function item($id)
    {
        return Item::whereId($id)->first(['title']);
    }
    /**
     * Display the specified resource.
     */
    public function show(DamageItem $damageItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $damageItem = DamageItem::findOrFail($id);
        return inertia('Damages/Edit', compact('damageItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DamageItemsRequest $request, $id)
    {
        $damageItem = DamageItem::findOrFail($id);
        $item = Item::whereCode($request->code)->first();
        if ($item->stock < ($request->stock - $damageItem->stock))
            return redirect()->back()->with('failed', 'الكمية المطلوبه غير متوفرة في المخزن');
        else {
            if ($request->stock > $damageItem->stock)
                $item->update(['stock' => $item->stock - ($request->stock - $damageItem->stock)]);
            else
                $item->update(['stock' => $item->stock + ($damageItem->stock - $request->stock)]);
            $damageItem->update(['stock' => $request->stock]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $damageItem = DamageItem::findOrFail($id);
        $item = Item::whereCode($damageItem->code)->first();
        $item->update(['stock' => $item->stock + $damageItem->stock]);
        $damageItem->delete();
    }
}
