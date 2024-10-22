<?php

namespace App\Providers;
namespace App\Events;


use App\Events\OrderCreated;
use App\Listeners\UpdateProductStock;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        OrderCreated::class => [
            UpdateProductStock::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
}
