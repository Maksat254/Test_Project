<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Doctrine\DBAL\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Cache::rememberForever('products', function () use ($request) {

         $query = Product::query();

            if ($request->has('color')) {
                $query->where('color', $request->input('color'));
            }

            if ($request->has('size')) {
                $query->where('size', $request->input('size'));
            }

            if ($request->has('in_stock')) {
                $query->where('in_stock', $request->input('in_stock'));
            }

            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->input('min_price'));
            }

            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->input('max_price'));
            }

            $products = $query->paginate(1);


        });
        return response()->json($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Заказ не найден'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Заказ успешно удалён'], 200);
    }
}
