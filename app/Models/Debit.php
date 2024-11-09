<?php

namespace App\Models;

use App\Observers\DebitObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(DebitObserver::class)]
class Debit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'amount',
        'notes',
        'status',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function payOfDebit()
    {
        return $this->hasMany(PayOfTheDebit::class);
    }
    public function paidAmount(): Attribute {
        return Attribute::make(
            get: fn() => $this->payOfDebit->sum('amount')
        );
    }
    public function leftAmount(): Attribute {
        return Attribute::make(
            get: fn() => $this->amount - $this->paid_amount
        );
    }

}
