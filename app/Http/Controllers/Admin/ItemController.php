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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::InStock()->latest()->paginate(30);
        return inertia('Items/Items', ['items' => ItemsResource::collection($items)]);
    }

    /**
     * Display a listing of the resource.
     */
    public function notInStock()
    {
        $items = Item::notInStock()->paginate(30);
        return inertia('Items/Items', ['items' => ItemsResource::collection($items)]);
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
