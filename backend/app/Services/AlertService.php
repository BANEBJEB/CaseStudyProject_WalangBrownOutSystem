<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Alert;

class AlertService
{
    public function runDailyHealthCheck(): array
    {
        return [
            'low_stock' => $this->checkLowStock(),
            'expiring' => $this->checkExpiring(),
            'expired' => $this->checkExpired(),
        ];
    }

    public function checkLowStock(): int
    {
        $count = 0;
        $products = Product::with('reorderPoint')->get();

        foreach ($products as $product) {
            if (!$product->reorderPoint) continue;

            $totalStock = $product->inventory()->sum('quantity');

            if ($totalStock < $product->reorderPoint->reorder_point) {
                $exists = Alert::where('product_id', $product->id)
                    ->where('alert_type', 'LOW_STOCK')
                    ->where('is_resolved', false)
                    ->exists();

                if (!$exists) {
                    Alert::create([
                        'product_id' => $product->id,
                        'alert_type' => 'LOW_STOCK',
                        'severity' => 'CRITICAL',
                        'message' => "Low stock: {$product->product_name} has only {$totalStock} units.",
                        'recommended_action' => "Order {$product->reorderPoint->reorder_point} units.",
                    ]);
                    $count++;
                }
            }
        }

        return $count;
    }

    public function checkExpiring(): int
    {
        $count = 0;
        $items = Inventory::with('product')->expiringSoon(60)->get();

        foreach ($items as $item) {
            $daysLeft = now()->diffInDays($item->expiry_date);
            Alert::create([
                'product_id' => $item->product_id,
                'alert_type' => 'EXPIRY',
                'severity' => 'WARNING',
                'message' => "{$item->product->product_name} batch {$item->batch_number} expires in {$daysLeft} days.",
                'recommended_action' => 'Prioritize this batch for sale.',
            ]);
            $count++;
        }

        return $count;
    }

    public function checkExpired(): int
    {
        $count = 0;
        $items = Inventory::with('product')->expired()->get();

        foreach ($items as $item) {
            Alert::create([
                'product_id' => $item->product_id,
                'alert_type' => 'EXPIRY',
                'severity' => 'CRITICAL',
                'message' => "{$item->product->product_name} batch {$item->batch_number} has expired.",
                'recommended_action' => 'Remove from inventory immediately.',
            ]);
            $item->status = 'EXPIRED';
            $item->save();
            $count++;
        }

        return $count;
    }
}