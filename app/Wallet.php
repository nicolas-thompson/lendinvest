<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public function debitBalance($amount)
    {
        $this->balance = $this->getOriginal('balance') + $amount;
        $this->save();
    }

    public function getBalanceAttribute($value)
    {
        return $value / 100;
    }
}
