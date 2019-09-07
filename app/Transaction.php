<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function tranche()
    {
        return $this->belongsTo('App\Tranche');
    }

    static public function store(Wallet $wallet, $amount, $type, $tranche_id)
    {
        $transaction = self::create([
            'user_id' => $wallet->user_id,
            'amount' => $amount,
            'type' => $type,
            'tranche_id' => $tranche_id
        ]);

        return response('Okay', 200);
    }
}
