<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStockStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::today();
        $updatedStatusEntries = Stock::whereDate('in_stock_date', $currentDate)->where('status', 'Out of stock')
            ->update(['status' => 'In stock']);

        $this->info("Updated {$updatedStatusEntries} stock entries to 'In-Stock'.");

        return Command::SUCCESS;
    }
}
