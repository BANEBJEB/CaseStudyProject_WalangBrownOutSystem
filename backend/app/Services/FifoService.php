<?php

namespace App\Services;

use App\Models\Inventory;

class FifoService
{
    public function getNextBatch(int $productId): ?Inventory
    {
        return Inventory::where('product_id', $productId)
            ->where('status', 'AVAILABLE')
            ->where('quantity', '>', 0)
            ->orderBy('manufacturing_date', 'asc')
            ->first();
    }

    public function processOrder(int $productId, int $requestedQty): array
    {
        $remaining = $requestedQty;
        $pickedBatches = [];

        $batches = Inventory::where('product_id', $productId)
            ->where('status', 'AVAILABLE')
            ->where('quantity', '>', 0)
            ->orderBy('manufacturing_date', 'asc')
            ->get();

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $available = $batch->available_quantity;
            $picked = min($available, $remaining);

            $batch->reserved_quantity += $picked;
            $batch->save();

            $pickedBatches[] = [
                'batch_number' => $batch->batch_number,
                'picked' => $picked,
                'warehouse_location' => $batch->warehouse_location,
            ];

            $remaining -= $picked;
        }

        if ($remaining > 0) {
            throw new \Exception("Insufficient stock. Short by {$remaining} units.");
        }

        return [
            'success' => true,
            'total_picked' => $requestedQty,
            'batches' => $pickedBatches,
        ];
    }
}