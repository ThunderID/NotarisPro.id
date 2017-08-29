<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Service\Subscription\GenerateTagihanSAAS;

class MonthlyBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notaris:subs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Monthly Billing ';

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
        //
        $tagihan    = new GenerateTagihanSAAS;
        $tagihan->bulanan();

        return true;
    }
}
