<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function given_we_have_a_loan()
    {
        $loan = factory('App\Loan')->create();

        // given we have a loan
        $this->assertInstanceOf('App\Loan', $loan);
    }

    /** @test */
    public function and_a_loan_has_a_tranche()
    {
        $loan = factory('App\Loan')->create();
        
        $tranche = factory('App\Tranche')->create(['loan_id' => $loan->id]);

        $this->assertEquals($tranche->id, $loan->tranche->first()->id);
    }
}  
