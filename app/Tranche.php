<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    public function canInvest($wallet, $amount, $now) : bool
    {
        if($wallet->balance < $amount) {
            return false;
        }
        if($amount > $this->balance) {
            return false;
        }
        
        if ($this->open() && $this->loan->open($now)) {
            return true;
        }

        return false;
    }

    public function debitBalance($amount)
    {
        $this->balance = $this->balance - $amount;
        return $this->save();
    }

    public function invest(Wallet $wallet, $amount, $now = null)
    {
       if ($this->canInvest($wallet, $amount, $now)) {
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
