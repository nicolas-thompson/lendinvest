<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_has_a_wallet()
    {
        $user = factory('App\User')->create();

        $wallet = factory('App\Wallet')->create(['user_id' => $user->id]);

        $this->assertInstanceOf('App\Wallet', $user->wallet->first());
    }

    /** @test */
    public function calculate_monthly_accrued_interest_command()
    {
        $investor = factory('App\User')->create();

        $loan = factory('App\Loan')->create();
        
        $tranche =  factory('App\Tranche')->create([
            'loan_id' => $loan->id,
        ]);

       factory('App\Transaction')->create([
            'tranche_id' => $tranche->id,
        ]);

        $this->artisan('lendinvest:calculate-interest');

        $this->assertDatabaseHas('interests', [
            'id' => 1,
            'user_id' => $investor->id,
            'tranche_id' => $tranche->id,
        ]);
    }
}
