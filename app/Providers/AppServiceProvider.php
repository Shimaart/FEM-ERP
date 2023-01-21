<?php

namespace App\Providers;

use App\Models\CostItem;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Karvaka\Wired\Table\Columns\Date;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Number;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'order' => Order::class,
            'shipment' => Shipment::class,
            'invoice' => Invoice::class,
            'cost_item' => CostItem::class,
        ]);

        Date::setDefaultFormat('d/m/Y');
        DateTime::setDefaultFormat('d/m/Y H:i');

        Number::setDefaultDecimalSeparator(',');
        Number::setDefaultThousandsSeparator(' ');
    }
}
