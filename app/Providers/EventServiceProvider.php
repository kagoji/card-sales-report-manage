<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\SalesPersonListEvent' => [
            'App\Listeners\SalesPersonListEventListener',
        ],

        'App\Events\CommissionListEvent' => [
            'App\Listeners\CommissionListEventListener',
        ],

        'App\Events\SalesTransactionEvent' => [
            'App\Listeners\SalesTransactionEventListener',
        ],

        'App\Events\SummaryReportGenerateEvent' => [
            'App\Listeners\SummaryReportGenerateEventListener',
        ],

        'App\Events\ZoneIndividualSummaryReportEvent' => [
            'App\Listeners\ZoneIndividualSummaryReportEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
