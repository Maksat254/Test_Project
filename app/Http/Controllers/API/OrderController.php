<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreateNotification;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {

        $orders = Cache::remember('orders.page' . $request->page, 60, function () use ($request) {
            return $this->orderService->filterAndSortOrders($request);
        });

        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {

        $order = $this->orderService->createOrder($request);

        event(new OrderCreated($order));

        Mail::to(auth()-user())->send(new OrderCreateNotification(auth()-user(),$order));

        return response()->json($order, 201);
    }
}
