<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
    {
        
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = $request->file('image');

        $path = $image->store('products', 'public');

        $validated['image'] = $path;

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show(string $id){
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ],404);

        }
        return response()->json([
            'success' => true,
            'data' => $product

        ],200);
    }

     public function update(Request $request, string $id)
    {

        // return response()->json([
        //     'message' => 'Update function reached',
        //     'id' => $id,
        //     'method' => $request->method(),
        //     'data' => $request->all()
        // ]);
    
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // print_r($request); die;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            
            
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }
    public function patch(Request $request, string $id)
    {
        $product = Product::find($id);

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
            'data' => $product->fresh()
        ], 200);
    }
    public function destroy(string $id){
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted SuccessFully'
        ],200);
    }
}