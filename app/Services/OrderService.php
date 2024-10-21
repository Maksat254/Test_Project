<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderService
{
    public function filterAndSortOrders(Request $request)
    {
        $query = Order::with('user', 'morphable');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), $request->input('order', 'asc'));
        }

        return $query->paginate(10);
    }
}

