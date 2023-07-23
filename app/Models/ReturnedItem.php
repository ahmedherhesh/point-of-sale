<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'sale_id',
        'notes',
        'qty',
        'status',
        'in_stock',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
    public function scopeAllowed($query)
    {
        $user = session()->get('user');
        //orWhereHas for query continue in diffrent table 
        return $query->WhereHas('item', function ($query) use ($user) {
            $query->whereDepotId($user->depot_id);
        });
    }
}
