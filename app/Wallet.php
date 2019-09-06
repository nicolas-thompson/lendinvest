<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public function debitBalance($amount)
    {
        $this->balance = $this->balance - $amount;
        $this->save();
    }
}
