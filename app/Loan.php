<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function tranche()
    {
        return $this->hasMany('App\Tranche');
    }
}
