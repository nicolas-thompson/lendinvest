<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WalletTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function each_investor_has_one_thousand_pounds_in_thier_virtual_wallet()
    {
        $investor = factory('App\User')->create();

        factory('App\Wallet')->create(['user_id' => $investor->id]);

        $this->assertEquals(1000, $investor->wallet->balance);
    }

    /** @test */
    public function an_investor_can_invest_one_thousand_pounds_in_a_tranche()
    {
        $investor = factory('App\User')->create();

        factory('App\Wallet')->create(['user_id' => $investor->id]);

        $loan = factory('App\Loan')->create([
            'start' => '01/10/2015',
            'end' => '15/11/2015',
        ]);

        $tranche = factory('App\Tranche')->create(['loan_id' => $loan->id]);

        $tranche->invest($investor->wallet, $amount = 1000);
    }
}
