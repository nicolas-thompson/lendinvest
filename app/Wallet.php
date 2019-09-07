<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $casts = [
        'balance' => 'int',
    ];

    public function debitBalance($amount)
    {
        $this->balance = $this->balance - $amount;
        $this->save();
    }
}
