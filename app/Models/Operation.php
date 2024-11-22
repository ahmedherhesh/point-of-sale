<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','customer_name', 'customer_phone','price','sale_price','discount','is_whole_sale'];
    function sales(){
        return $this->hasMany(Sale::class,'operation_id');
    }
    protected $casts = [
        'is_whole_sale' => 'boolean',
    ];
}
