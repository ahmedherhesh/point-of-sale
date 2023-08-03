<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['user_id',  'parent_id', 'name'];
    function scopeAllowed($query)
    {
        $user = session()->get('user');
        return $query->whereDepotId($user->depot_id);
    }
    function subCats()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    static function tree()
    {
        $catsTree = self::orderByDesc('id')->whereParentId(null)->get();
        $catsTree->filter(function ($cat) {
            $cat->children;
        });
        return $catsTree;
    }
    function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
}
