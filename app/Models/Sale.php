<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'operation_id',
        'notes',
        'price',
        'price_of_sale',
        'status',
        'qty',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function scopeAllowed($query)
    {
        $user = session()->get('user');
        return $query->whereDepotId($user->depot_id);
    }
}
