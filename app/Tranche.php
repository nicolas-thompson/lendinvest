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
}
