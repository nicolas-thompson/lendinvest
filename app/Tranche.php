<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    public function canInvest($wallet, $amount) : bool
    {
        if($wallet->getOriginal('balance') < $amount) {
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

    public function debitBalance($amount)
    {
        $this->balance = $this->balance - $amount;
        $this->save();
    }

    public function getBalanceAttribute($value) : int
    {
        return $value / 100;
    }

    public function invest(Wallet $wallet, $amount)
    {
       if ($this->canInvest($wallet, $amount)) {
           $this->debitBalance($amount);
           $wallet->debitBalance($amount);
       }
    }

    public function loan() : object 
    {
        return $this->belongsTo('App\Loan');
    }

    public function open() : bool
    {
        return $this->open;
    } 
}
