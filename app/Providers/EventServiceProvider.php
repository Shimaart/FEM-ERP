<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Shipment;
use App\Observers\LeadHistoryObserver;
use App\Observers\LeadOrderChangesObserver;
use App\Observers\LeadOrderPaymentChangesObserver;
use App\Observers\OrderHistoryObserver;
use App\Observers\OrderItemHistoryObserver;
use App\Observers\OrderItemTotalAmountObserver;
use App\Observers\OrderPaymentHistoryObserver;
use App\Observers\OrderPaymentPaidAmountObserver;
use App\Observers\OrderRefundHistoryObserver;
use App\Observers\OrderRefundTotalAmountObserver;
use App\Observers\OrderShipmentHistoryObserver;
use App\Observers\OrderShipmentTotalAmountObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $subscribe = [

    ];

    public function boot(): void
    {
        // Order history
        OrderItem::observe(OrderItemHistoryObserver::class);
        Payment::observe(OrderPaymentHistoryObserver::class);
        Shipment::observe(OrderShipmentHistoryObserver::class);
        Refund::observe(OrderRefundHistoryObserver::class);
        Order::observe(OrderHistoryObserver::class);

        // Order total amount
        OrderItem::observe(OrderItemTotalAmountObserver::class);
        Shipment::observe(OrderShipmentTotalAmountObserver::class);
        Refund::observe(OrderRefundTotalAmountObserver::class);

        // Order paid amount
        Payment::observe(OrderPaymentPaidAmountObserver::class);

        // Lead changes
        Order::observe(LeadOrderChangesObserver::class);
        Payment::observe(LeadOrderPaymentChangesObserver::class);

        // Lead history
        Lead::observe(LeadHistoryObserver::class);
    }
}
