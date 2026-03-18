<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Http\Resources\ProductResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->latest()
            ->paginate(10);

        return ProductResource::collection($products);
    }
}