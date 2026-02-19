<?php
namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Public listing → only active products
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Product::query();

        // Regular member → only their own products
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            $query->where('user_id', $user->id)
                ->where('status', 'active'); // optional, if you want public listing
        }

        // Admin → can filter by user_id or see all
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        // Optional status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10);

        return ProductResource::collection($products);
    }


    /**
     * Owner listing → include inactive
     */
    public function myProducts(Request $request)
    {
        $products = $request->user()
            ->products()
            ->latest()
            ->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store product
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')
                ->store('products', 'public');
        }

        $data['status'] = 'active'; // default
        $data['user_id'] = auth()->id();

        $product = Product::create($data);

        return new ProductResource($product);
    }

    /**
     * Show product
     */
    public function show(Product $product)
    {
        // If inactive, only owner can see
        if ($product->status === 'inactive' &&
            $product->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not found.'
            ], 404);
        }

        return new ProductResource($product);
    }

    /**
     * Update product (including status)
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {

            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }

            $data['photo_path'] = $request->file('photo')
                ->store('products', 'public');
        }

        $product->update($data);

        return new ProductResource($product->fresh());
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.'
        ]);
    }
}
