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
        
        factory('App\Wallet')->create(['user_id' => $user->id]);

        $this->assertInstanceOf('App\Wallet', $user->wallets);
    }
}
