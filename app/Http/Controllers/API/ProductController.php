<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = Cache::remember('products.page' . $request->page, 60, function () use ($request) {
            return $this->productService->filterAndSortProducts($request);
        });

        return response()->json($products);
    }
}
