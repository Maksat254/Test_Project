<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Cache::remember('orders.page' . $request->page, 60, function () use ($request){
            return Order::with('user', 'morphable')
                ->when($request->has('status'), function ($query) use ($request){
                    $query->where('status', $request->status);
                })
                ->when($request->has('sort_by'), function ($query) use ($request) {
                    $query->orderBy($request->sort_by, $request->get('order', 'asc'));
                })
                ->paginate(10);
        });
        return response()->json($orders);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'morphable_id' => 'required|integer',
            'morphable_type' => 'required|string|in:App\\Models\\Product,App\\Models\\Service',
            'status' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $validated['user_id'] = auth()->id();

        $modelClass = $validated['morphable_type'];
        $model = $modelClass::findOrFail($validated['morphable_id']);

        if (!auth()->check()) {
            return response()->json(['error' => 'Необходимо авторизоваться'], 401);
        }

        $model = $validated['morphable_type']::find($validated['morphable_id']);
        if (!$model) {
            return response()->json(['error' => 'Сущность не найдена'], 404);
        }

        if ($model instanceof Product) {
            if ($model->quantity < $validated['quantity']) {
                return response()->json(['error' => 'Недостаточно товаров на складе'], 400);
            }

            $model->quantity -= $validated['quantity'];
            $model->save();


            $order = new Order($validated);
            $order->user_id = auth()->id();
            $model->orders()->save($order);


            // Notification::send($order->user, new OrderCreatedNotification($order));

            return response()->json(['message' => 'Заказ успешно создан', 'order' => $order, 'product_quantity' => $model->quantity], 201);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('morphable')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Заказ не найден'], 404);
        }

        Log::info('Просмотр заказа', ['order_id' => $id, 'user_id' => auth()->id()]);

        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        if (!auth()->user()->can('delete', $order)) {
            return response()->json(['error' => 'Недостаточно прав для удаления заказа'], 403);
        }

        $order->delete();

        Log::info('Удаление заказа', ['order_id' => $id, 'user_id' => auth()->id()]);

        return response()->json(['message' => 'Заказ успешно удалён']);
    }
}
