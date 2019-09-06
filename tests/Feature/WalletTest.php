<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\CarbonImmutable;
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

        $this->assertEquals(100000, $investor->wallet->balance);
    }

    /** @test */
    public function an_investor_can_invest_one_thousand_pounds_in_a_tranche()
    {
        $investor = factory('App\User')->create();

        factory('App\Wallet')->create(['user_id' => $investor->id]);

        $start = CarbonImmutable::createFromDate('09/01/2019', 'Europe/London');
        $end = CarbonImmutable::createFromDate('10/01/2019', 'Europe/London');

        $loan = factory('App\Loan')->create([
            'start' => $start,
            'end' => $end,
        ]);

        $tranche = factory('App\Tranche')->create(['loan_id' => $loan->id]);

        $tranche->invest($investor->wallet, $amount = 100000);

        $this->assertEquals(0, $investor->wallet->balance);
    }
}
