<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    public function canInvest($wallet, $amount, $now)
    {
        try {

            if($wallet->balance < $amount) {
                throw new \Exception('The wallet balance is smaller than the amount.'); 
            }   
 
         } catch (\Exception $e) {
            return response($e, 422);
         }
        
         try {

            if($amount > $this->balance) {
                throw new \Exception('The amount is larger than the tranche balance.'); 
            }   
 
         } catch (\Exception $e) {
            return response($e, 422);
         }
        
        if ($this->open() && $this->loan->open($now)) {
            return response('yes', 200);
        }

        return response($e, 422);
    }

    public function debitBalance($amount)
    {
        $this->balance = $this->balance - $amount;
        return $this->save();
    }

    public function invest(Wallet $wallet, $amount, $now = null)
    {
        $this->debitBalance($amount);
        $wallet->debitBalance($amount);

        Transaction::store($wallet, $amount, 'credit', $this->id);
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
