<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    public function invest(Wallet $wallet, $amount)
    {
        dd($this->loan->open());
    }

    public function loan()
    {
        return $this->belongsTo('App\Loan');
    }

    public function canInvest($wallet, $amount) : bool
    {
        if($wallet->balance < $amount) {
            return false;
        }

        if($amount > $this->balance) {
            return false;
        }

        if ($this->open() && $this->loan->open()) {
            return true;
        }

        return false;
    }

}
