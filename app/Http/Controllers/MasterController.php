<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemsResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;

class MasterController extends Controller
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
