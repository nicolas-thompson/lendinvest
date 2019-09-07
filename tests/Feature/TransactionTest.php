<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Transaction;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_writes_to_a_tranaction_ledger()
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

        $this->assertDatabaseHas('transactions', [
            'id' => 1,
            'user_id' => 1,
            'amount' => 100000,
            'type' => 'credit',
            'tranche_id' => 1,
        ]);
    }
}
