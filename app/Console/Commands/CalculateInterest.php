<?php

namespace App\Console\Commands;

use App\User;
use App\Tranche;
use App\Interest;
use App\Transaction;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class CalculateInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lendinvest:calculate-interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates monthly interest accrued by investor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(Transaction::all() as $transaction) {

            $investor = User::where('id', $transaction->user_id)->first();
            
            $tranche = Tranche::where('id', $transaction->tranche_id)->first();

            $interest = $tranche->interest($investor);

            Interest::create([
                'user_id' => $investor->id,
                'tranche_id' => $tranche->id,
                'amount' => $interest->content(),
            ]);
        }

        return response('okay', 200);
    }
}
