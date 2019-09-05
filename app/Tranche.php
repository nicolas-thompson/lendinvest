<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{

    // balance mutator 
    //
    // - https://laravel.com/docs/6.0/eloquent-mutators
    public function getBalanceAttribute($value)
    {
        return $value / 100;
    }

    public function open() : bool
    {
        return $this->open;
    }

    public function invest(Wallet $wallet, $amount)
    {
       if ($this->canInvest($wallet, $amount)) {
           dd('invest here');
       }
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
