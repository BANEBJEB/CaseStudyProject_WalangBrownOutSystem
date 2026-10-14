<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReorderPoint;
use App\Services\ReorderService;
use Illuminate\Http\Request;

class ReorderController extends Controller
{
    protected $reorderService;

    public function __construct(ReorderService $reorderService)
    {
        $this->reorderService = $reorderService;
    }

    public function index()
    {
        return response()->json(ReorderPoint::with('product')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'min_stock' => 'required|integer',
            'max_stock' => 'required|integer',
            'reorder_point' => 'required|integer',
            'seasonal_multiplier' => 'numeric|min:0.5|max:3',
            'lead_time_days' => 'integer|min:1',
        ]);

        $reorder = ReorderPoint::updateOrCreate(
            ['product_id' => $validated['product_id']],
            $validated
        );

        return response()->json($reorder, 201);
    }

    public function calculate($productId)
    {
        return response()->json($this->reorderService->calculateReorderPoint($productId));
    }
}