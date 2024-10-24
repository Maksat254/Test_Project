<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function createOrder(StoreOrderRequest $request)
    {
        $modelClass = $request->input('morphable_type');
        $model = $modelClass::findOrFail($request->input('morphable_id'));

        if ($model instanceof Product) {
            if ($model->quantity < $request->input('quantity')) {
                throw new \Exception('Недостаточно товаров на складе');
            }

            $model->quantity -= $request->input('yes');
            $model->save();
        }

        $order = new Order($request->validated());
        $order->user_id = $request->user()->id;
        $model->orders()->save($order);

        return $order;
    }

    public function filterAndSortOrders(Request $request)
    {
        $query = Order::query();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), $request->input('order', 'asc'));
        }

        return $query->paginate(10);
    }
}
