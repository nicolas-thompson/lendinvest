<?php

namespace App;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function open($now = null) : bool
    {
        $now = $now ?? CarbonImmutable::now('Europe/London');

        if ($now->greaterThan($this->start) && $now->lessThan($this->end)) {

            return true;
        }

        return false;
    }

    public function tranche()
    {
        return $this->hasMany('App\Tranche');
    }
}
