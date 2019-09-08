<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Transaction;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrancheTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function given_we_have_a_tranche()
    {
        $tranche = factory('App\Tranche')->create();
        
        // given we have a tranche
        $this->assertInstanceOf('App\Tranche', $tranche);
    }

    /** @test */
    public function it_cannot_invest_when_tranche_has_no_balance_available()
    {
        $start = CarbonImmutable::createFromDate('10/01/2015', 'Europe/London');
        $now = CarbonImmutable::createFromDate('11/06/2015', 'Europe/London');
        $end = CarbonImmutable::createFromDate('11/15/2015', 'Europe/London');

        $loan = factory('App\Loan')->create([
            'start' => $start,
            'end' => $end,
        ]);

        $tranche = factory('App\Tranche')->create([
            'loan_id' => $loan->id
        ]);

        $this->assertEquals(100000, $loan->tranche->first()->balance);

        $investor1 = factory('App\User')->create();
        $investor2 = factory('App\User')->create();

        factory('App\Wallet')->create(['user_id' => $investor1->id]);
        factory('App\Wallet')->create(['user_id' => $investor2->id]);

        $canInvest = $tranche->canInvest($investor1->wallet, $amount = 100000, $now);

        if ( $canInvest->status() === 200 ) {

            $tranche->invest($investor1->wallet, $amount = 100000, $now);
        } 

        $this->assertEquals(0, $investor1->wallet->balance);
        $this->assertEquals(0, $tranche->balance);

        $canInvest = $tranche->canInvest($investor2->wallet, $amount = 100000, $now);

        if( $canInvest->status() === 200 ) {

            $tranche->invest($investor2->wallet, $amount = 100000, $now);
        }

        $this->assertEquals(100000, $investor2->wallet->balance);
        $this->assertEquals(0, $tranche->balance);
    }

    /** @test */
    public function calculate_monthly_interest()
    {
        $investor = factory('App\User')->create();

        $wallet = factory('App\Wallet')->create([
            'user_id' => $investor->id
            ]);

        $loan = factory('App\Loan')->create();
        $tranche = factory('App\Tranche')->create([
            'loan_id' => $loan->id,
            'rate' => 3,
        ]);

        $canInvest = $tranche->canInvest($wallet, $amount = 50000);

        if ($canInvest->status() === 200) {
            
            $tranche->invest($investor->wallet, $amount = 50000);
        }

        $canInvest = $tranche->canInvest($wallet, $amount = 20000);

        if ($canInvest->status() === 200) {
            
            $tranche->invest($investor->wallet, $amount = 20000);
        }
        
        $interest = $tranche->interest($investor);
                       
        $this->assertEquals('€'.'72', '€'.$interest->content());
    }
}
