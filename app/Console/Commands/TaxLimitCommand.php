<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Production;
use App\Models\Shipment;
use App\Models\TaxLimit;
use App\Models\Unit;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Environment\Console;

class TaxLimitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tax-limit:sync {--month_date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tax limit synchronized';

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
    public function handle(): void
    {
        $actualDate = new Carbon('first day of this month');
        if ($this->option('month_date')) {
            try {
                $actualDate = Carbon::createFromFormat('Y-m-d', $this->option('month_date'));
            } catch (\Exception $e) {
                dd('дата введена в неверном формате');
            }
        }

        $monthDate = $actualDate->format('Y-m-d');
        $lastMonthDay = new Carbon($monthDate);
        $lastMonthDay->endOfMonth();
        $startDate = new Carbon($monthDate);
        $startDate->startOfMonth();
        $endDate = new Carbon($monthDate);
        $endDate->endOfMonth();
        $endDate->modify('+1 day');

        $taxLimit = TaxLimit::query()->firstOrCreate([
            'month' => $startDate->format('Y-m-d')
        ]);

        $value = $this->calculateTaxLimit($startDate, $endDate);
        $taxLimit->update([
            'value' => $value
        ]);

        if (\Carbon\Carbon::now()->format('Y-m-d') === $lastMonthDay->format('Y-m-d')
            || $actualDate->format('Y-m-d') === $lastMonthDay->format('Y-m-d')
        ) {
            $taxLimit->update([
                'status' => TaxLimit::STATUS_CLOSED
            ]);
        }
    }

    protected function calculateTaxLimit($startDate, $endDate): int
    {
        $payments = Payment::query()
            ->where('status', '=', Payment::STATUS_PAID)
            ->whereIn('payment_type', [Payment::PAYMENT_TYPE_CASH, Payment::PAYMENT_TYPE_CASHLESS])
            ->whereBetween('paid_at', [
                $startDate->format('Y-m-d'), $endDate->format('Y-m-d')
            ])
            ->get();

        $total = $payments->sum('amount');
        $value = ceil($total/100*20);

        $income = $payments->where('amount', '>=', 0)->sum('amount');
        $this->info('Income: ' . $income);
        $outgoing = $payments->where('amount', '<', 0)->sum('amount');
        $this->info('Outgoing: ' . $outgoing);
        $this->info('TaxLimit: ' . $value);

        return $value;
    }
}
