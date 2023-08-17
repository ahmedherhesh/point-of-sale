<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MasterController;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends MasterController
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
        if ($request->inStock)
            $items->inStock();
        if ($request->notInStock)
            $items->notInStock();
        $items = $items->latest()->paginate(100);
        return ItemsResource::collection($items);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Items/Items', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function notInStock()
    {
        $this->data['items'] = ItemsResource::collection(Item::notInStock()->paginate(100));
        return inertia('Items/Items', $this->data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catsTree = Category::tree();
        return inertia('Items/Create', compact('catsTree'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $data = $request->all();
        if (!$request->image)
            $data = $request->except('image');
        if (!$request->code)
            $data['code'] = time();
        $data['user_id'] = $this->user()->id;
        Item::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $catsTree = Category::tree();
        return inertia('Items/Edit', compact('item', 'catsTree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, Item $item)
    {
        $data = $request->all();
        if (!$request->image)
            $data = $request->except('image');
        if (!$request->code)
            $data = $request->except('code');
        $item->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
