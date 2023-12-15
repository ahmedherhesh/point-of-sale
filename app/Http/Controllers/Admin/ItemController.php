<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends MasterController
{
    public $permission = 'المنتجات';
    public $can = [
        'المنتجات' => ['index', 'show', 'notInStock'],
        'الباركود' => 'barcode'
    ];

    function itemsWithFilter($request)
    {
        $items = Item::query();
        if ($request->code) {
            $items->whereCode($request->code);
        } else {
            if ($request->title)
                $items->where('title', 'LIKE', "%$request->title%");
            if ($request->cat_id)
                $items->whereCatId($request->cat_id)->orWhere('sub_cat_id', $request->cat_id);
            if ($request->company_id)
                $items->whereCompanyId($request->company_id);
        }
        if ($request->inStock || (!$request->inStock && !$request->notInStock))
            $items->inStock();
        if ($request->notInStock)
            $items->notInStock();

        return $items;
    }
    function itemsFilter(Request $request)
    {
        $request->validate(['code' => 'nullable|exists:items,code']);
        $items = $this->itemsWithFilter($request)->orderByDesc('id')->paginate($this->item_count);
        return ItemsResource::collection($items);
    }
    function barcode(Request $request)
    {
        $data = $this->data();
        $data['items'] = ItemsResource::collection($this->itemsWithFilter($request)->orderByDesc('id')->paginate($this->item_count));
        return inertia('Items/Barcode', $data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->data();
        $items = $this->itemsWithFilter($request);
        $data['totalSalePrice'] = 0;
        $data['totalPrice'] = 0;
        foreach ($items->get(['price','sale_price','stock']) as $item) {
            $data['totalSalePrice'] += $item->sale_price * $item->stock;
            $data['totalPrice'] += $item->price * $item->stock;
        }
        $data['items'] = ItemsResource::collection($items->orderByDesc('id')->paginate($this->item_count));
        return inertia('Items/Items', $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function notInStock()
    {
        $data = $this->data();
        $data['items'] = ItemsResource::collection(Item::notInStock()->paginate($this->item_count));
        return inertia('Items/Items', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catsTree = Category::tree();
        $companies = Company::get();
        return inertia('Items/Create', compact('catsTree', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $data = $request->all();
        if (!$request->image)
            $data = $request->except('image');
        $data['user_id'] = $this->user()->id;
        $item = Item::create($data);
        if (!$request->code) {
            $code = strlen("$item->id") < 3 ? '00' . $item->id : $item->id;
            $item->update(['code' => $code]);
        }
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
        $companies = Company::get();
        return inertia('Items/Edit', compact('item', 'catsTree', 'companies'));
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
    public function destroy($id)
    {
        $itemHasSale = Item::whereId($id)->has('sale')->first();
        if ($itemHasSale)
            $itemHasSale->update(['stock' => 0]);
        else
            Item::find($id)->delete();
    }
}
