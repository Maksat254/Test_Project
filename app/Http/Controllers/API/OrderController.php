<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
}
