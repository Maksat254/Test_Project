<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all();
        return response()->json($order);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'morphable_id' => 'required|integer',
            'morphable_type' => 'required|string|',
            'status' => 'required|string',
            'details' => 'nullable|string',
        ]);

        $order = new Order([
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
            'morphable_id' => $validated['morphable_id'],
            'details' => $validated['details'],
            'morphable_type' => $validated['morphable_type'],
        ]);

        $model = $validated['morphable_type']::find($validated['morphable_id']);
        if (!$model) {
            return response()->json(['error' => 'Сущность не найдена'], 404);
        }

        $model->orders()->save($order);

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
