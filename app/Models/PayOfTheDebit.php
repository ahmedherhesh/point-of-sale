<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayOfTheDebit extends Model
{
    use HasFactory;
    protected $fillable = [
        'debit_id',
        'amount',
    ];
}
