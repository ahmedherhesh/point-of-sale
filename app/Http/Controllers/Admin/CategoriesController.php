<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Item;

class CategoriesController extends MasterController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoriesResource::collection(Category::latest()->paginate(30));
        return inertia('Categories/Categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereParentId(null)->latest()->get();
        return inertia('Categories/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->user()->id;
        Category::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->data['items'] = ItemsResource::collection(Item::whereCatId($id)->orWhere('sub_cat_id',$id)->paginate(100));
        return inertia('Items/Items', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::whereParentId(null)->latest()->get();
        return inertia('Categories/Edit', compact('categories','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->all();
        $data['user_id'] = $this->user()->id;
        $category->update($data);
        redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        redirect()->back();
    }
}
