<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    // balance mutator 
    //
    // - https://laravel.com/docs/6.0/eloquent-mutators
    public function getBalanceAttribute($value)
    {
        return $value / 100;
    }
}
