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
    public function a_loan_has_a_tranche()
    {
        $loan = factory('App\Loan')->create();
        
        $tranche = factory('App\Tranche')->create(['loan_id' => $loan->id]);

        $this->assertEquals($tranche->id, $loan->tranche->first()->id);
    }

    /** @test */
    public function a_loan_start_first_october_twenty_fifteen_end_fifteenth_november_twenty_fifteen()
    {
        $loan = factory('App\Loan')->create([
            'start' => '01/10/2015',
            'end' => '15/11/2015',
        ]);

        $this->assertEquals($loan->start, '01/10/2015');
        $this->assertEquals($loan->end, '15/11/2015');
    }

    /** @test */
    public function a_loan_has_two_tranches_called_a_and_b()
    {
        $loan = factory('App\Loan')->create();

        $trancheA = factory('App\Tranche')->create(['loan_id' => $loan->id]);
        $trancheB = factory('App\Tranche')->create(['loan_id' => $loan->id]);
        
        $this->assertCount(2, $loan->tranche);
    }

    /** @test */
    public function trancheA_has_an_interest_rate_of_3_percent()
    {
        $trancheA = factory('App\Tranche')->create(['rate' => 3]);

        $this->assertEquals(3, $trancheA->rate);
    }

    /** @test */
    public function trancheB_has_an_interest_rate_of_6_percent()
    {
        $trancheB = factory('App\Tranche')->create(['rate' => 6]);

        $this->assertEquals(6, $trancheB->rate);
    }

    /** @test */
    public function each_tranche_has_maximum_one_thousand()
    {
        $trancheA = factory('App\Tranche')->create(['maximum' => 100000]);
        $trancheB = factory('App\Tranche')->create(['maximum' => 100000]);

        $this->assertEquals(100000, $trancheA->maximum);
        $this->assertEquals(100000, $trancheB->maximum);
    }

}  
