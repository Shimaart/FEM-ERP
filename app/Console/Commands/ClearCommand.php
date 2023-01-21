<?php

namespace App\Console\Commands;

use App\Models\CostItem;
use App\Models\Item;
use App\Models\Order;
use App\Models\Production;
use App\Models\Shipment;
use App\Models\Unit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data clear';

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
     * @return int
     */
    public function handle()
    {
        Production::query()->forceDelete();
        Order::query()->forceDelete();
        Shipment::query()->forceDelete();
        CostItem::query()->forceDelete();
//        Item::query()->update([
//            'quantity' => 0
//        ]);
    }
}
