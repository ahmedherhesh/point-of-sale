<?php

namespace App\Observers;

use App\Models\Debit;

class DebitObserver
{
    public function creating(Debit $debit)
    {
        $debit->user_id = auth()->id();
    }
}
