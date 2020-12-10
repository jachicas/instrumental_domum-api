<?php

namespace App\Providers;

use App\Events\OffterRegistered;
use App\Events\SaleTotal;
use App\Events\UpdateSaleTotal;
use App\Http\Controllers\OffterController;
use App\Listeners\UpdateStatusOffter;
use App\Listeners\UpdateTotalSaleDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
