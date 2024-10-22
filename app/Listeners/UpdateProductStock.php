<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        if ($order->morphable_type === Product::class) {
            $product = Product::find($order->morphable_id);
            if ($product && $product->quantity >= $order->quantity) {
                $product->quantity -= $order->quantity;
                $product->save();
            }
        }
    }
}
