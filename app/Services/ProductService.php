<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{

    public function createProduct(Request $request)
    {
        $product = Product::create([
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
        ]);

        return $product;
    }



    public function filterAndSortProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('color')) {
            $query->where('color', $request->input('color'));
        }

        if ($request->has('size')) {
            $query->where('size', $request->input('size'));
        }

        if ($request->has('quantity')) {
            $query->where('quantity', $request->input('quantity'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), $request->input('order', 'asc'));
        }

        return $query->paginate(10);
    }
}

