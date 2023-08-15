<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'customer_phone', 'discount'];
    function sales(){
        return $this->hasMany(Sale::class,'operation_id');
    }
}
