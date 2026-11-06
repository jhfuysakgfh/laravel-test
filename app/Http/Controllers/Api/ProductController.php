<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    // Get only logged-in user's products
    public function index(Request $request)
    {
        $validated = $request->validate([
        'per_page' => 'sometimes|integer|min:1|max:50',
        'search' => 'sometimes|string|max:255',
        'min_price' => 'sometimes|numeric|min:0',
        'max_price' => 'sometimes|numeric|min:0',
    ]);
    $per_page = $validated['per_page'] ?? 10;
    $query = $request->user()->products();
    // print_r($validated);die;
    if (!empty($validated['search'])) {
        $search = $validated['search'];

        $query->where(function ($q) use ($search) {
            $q->where('name', 'ILIKE', "%{$search}%")
              ->orWhere('description', 'ILIKE', "%{$search}%");
        });
    }
    // Filter by minimum price
    if (isset($validated['min_price'])) {
        $query->where('price', '>=', $validated['min_price']);
    }

    // Filter by maximum price
    if (isset($validated['max_price'])) {
        $query->where('price', '<=', $validated['max_price']);
    }

        $products = $query->paginate($per_page);

        return ProductResource::collection($products)
        ->additional([
            'success' => true

        ]);
        
    }

    // Create product and automatically assign owner
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('image')->store('products', 'public');

        $validated['image'] = $path;

        // user_id is assigned by Laravel, not by Postman
        $product = $request->user()->products()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201);
    }

    // Get one product belonging to logged-in user
    public function show(Request $request, string $id)
    {
        $product = $request->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ], 200);
    }

    // Fully update a product
    public function update(Request $request, string $id)
    {
        $product = $request->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product->fresh())
        ], 200);
    }

    // Partially update a product
    public function patch(Request $request, string $id)
    {
        $product = $request->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|nullable|string|max:1000',
            'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        if (empty($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least one field to update'
            ], 422);
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product partially updated successfully',
            'data' => new ProductResource($product->fresh())
        ], 200);
    }

    // Delete only logged-in user's product
    public function destroy(Request $request, string $id)
    {
        $product = $request->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
