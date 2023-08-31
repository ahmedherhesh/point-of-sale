<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;

class MasterController extends Controller
{
    public $data;
    public $item_count = 50;
    function __construct()
    {
        $this->data = [
            'categories' => Category::orderByDesc('id')->get(),
            'companies' => Company::orderByDesc('id')->get(),
            'items' => ItemsResource::collection(Item::inStock()->orderByDesc('id')->paginate($this->item_count)),
        ];
    }
    public function user()
    {
        return session()->get('user');
    }
    public function isAdmin()
    {
        if (in_array($this->user()->role, ['super-admin', 'admin']))
            return true;
        return false;
    }
}
