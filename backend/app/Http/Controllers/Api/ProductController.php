<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('reorderPoint')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku',
            'product_name' => 'required|string|max:200',
            'category' => 'required|in:AC_UNIT,AIR_PURIFIER,FILTER,THERMOSTAT',
            'unit_price' => 'required|numeric|min:0',
            'seasonality' => 'required|in:SUMMER,WINTER,YEAR_ROUND',
            'shelf_life_months' => 'nullable|integer|min:1',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return response()->json(Product::with('inventory', 'reorderPoint')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}