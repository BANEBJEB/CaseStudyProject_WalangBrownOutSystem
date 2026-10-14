<?php

namespace App\Services;

use App\Models\Product;

class ReorderService
{
    public function calculateReorderPoint(int $productId): array
    {
        $product = Product::with('reorderPoint')->findOrFail($productId);
        $config = $product->reorderPoint;

        $avgDailySales = 10;
        $leadTime = $config->lead_time_days ?? 7;
        $seasonalMultiplier = $this->getSeasonalMultiplier($product);
        $safetyStock = $avgDailySales * $leadTime * 0.2;
        $reorderPoint = ($avgDailySales * $leadTime * $seasonalMultiplier) + $safetyStock;
        $currentStock = $product->total_available;

        return [
            'product_id' => $productId,
            'product_name' => $product->product_name,
            'avg_daily_sales' => $avgDailySales,
            'lead_time_days' => $leadTime,
            'seasonal_multiplier' => $seasonalMultiplier,
            'safety_stock' => round($safetyStock, 2),
            'reorder_point' => round($reorderPoint, 2),
            'current_stock' => $currentStock,
            'needs_reorder' => $currentStock <= $reorderPoint,
            'recommended_order_qty' => max(0, round($reorderPoint * 2 - $currentStock, 2)),
        ];
    }

    private function getSeasonalMultiplier(Product $product): float
    {
        $month = now()->month;

        if ($product->seasonality === 'SUMMER') {
            if (in_array($month, [6, 7, 8])) return 1.5;
            if (in_array($month, [9, 10, 11])) return 1.2;
            if (in_array($month, [12, 1, 2])) return 0.8;
        }

        return 1.0;
    }
}