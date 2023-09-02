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
    public $permission;
    public $can = [];
    function __construct()
    {
        $this->can(array_merge([
            "{$this->permission}" => ['index','show'],
            "اضافة {$this->permission}" => ['create', 'store'],
            "تعديل {$this->permission}" => ['edit', 'update'],
            "حذف {$this->permission}" => ['destroy'],
        ],$this->can));
    }
    function can($permissions = [])
    {
        foreach ($permissions as $permission => $functions) {
            $this->middleware("permission:$permission", ["only" => $functions]);
        }
    }
    function data()
    {
        return [
            'categories' => Category::orderByDesc('id')->get(),
            'companies' => Company::orderByDesc('id')->get(),
            'items' => ItemsResource::collection(Item::inStock()->orderByDesc('id')->paginate($this->item_count)),
        ];
    }
    public function user()
    {
        return auth()->user();
    }
    public function isAdmin()
    {
        if ($this->user() && in_array($this->user()->getRoleNames(), ['super-admin', 'admin']))
            return true;
        return false;
    }
}
