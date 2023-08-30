<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageItem extends Model
{
    use HasFactory;
    protected $fillable = ['code','stock'];
    function item(){
        return $this->belongsTo(Item::class,'code');
    }
}
