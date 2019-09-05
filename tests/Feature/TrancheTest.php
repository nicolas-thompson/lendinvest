<?php

namespace Tests\Feature;

use Tests\TestCase;
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
}
