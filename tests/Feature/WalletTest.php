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
        $investor= factory('App\User')->create();

        factory('App\Wallet')->create(['user_id' => $investor->id]);

        $this->assertEquals(1000, $investor->wallet->balance / 100);
    }
}
