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
        $this->assertInstanceOf('Loan', $loan);
    }
}  
