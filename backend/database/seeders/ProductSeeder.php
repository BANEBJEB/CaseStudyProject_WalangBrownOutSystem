<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ReorderPoint;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['sku' => 'AC-001', 'product_name' => 'Portable AC 1.5HP', 'category' => 'AC_UNIT', 'unit_price' => 15999.00, 'seasonality' => 'SUMMER'],
            ['sku' => 'AC-002', 'product_name' => 'Portable AC 2.0HP', 'category' => 'AC_UNIT', 'unit_price' => 18999.00, 'seasonality' => 'SUMMER'],
            ['sku' => 'AP-001', 'product_name' => 'Air Purifier HEPA', 'category' => 'AIR_PURIFIER', 'unit_price' => 8999.00, 'seasonality' => 'YEAR_ROUND'],
            ['sku' => 'FL-001', 'product_name' => 'HEPA Filter Replacement', 'category' => 'FILTER', 'unit_price' => 1299.00, 'shelf_life_months' => 9, 'seasonality' => 'YEAR_ROUND'],
            ['sku' => 'FL-002', 'product_name' => 'Carbon Filter Replacement', 'category' => 'FILTER', 'unit_price' => 899.00, 'shelf_life_months' => 9, 'seasonality' => 'YEAR_ROUND'],
            ['sku' => 'TS-001', 'product_name' => 'Smart Thermostat Pro', 'category' => 'THERMOSTAT', 'unit_price' => 4999.00, 'seasonality' => 'YEAR_ROUND'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $reorderConfigs = [
            ['product_id' => 1, 'min_stock' => 50, 'max_stock' => 500, 'reorder_point' => 100, 'seasonal_multiplier' => 1.50],
            ['product_id' => 2, 'min_stock' => 30, 'max_stock' => 300, 'reorder_point' => 60, 'seasonal_multiplier' => 1.50],
            ['product_id' => 3, 'min_stock' => 20, 'max_stock' => 150, 'reorder_point' => 40, 'seasonal_multiplier' => 1.00],
            ['product_id' => 4, 'min_stock' => 100, 'max_stock' => 1000, 'reorder_point' => 200, 'seasonal_multiplier' => 1.00],
            ['product_id' => 5, 'min_stock' => 80, 'max_stock' => 800, 'reorder_point' => 150, 'seasonal_multiplier' => 1.00],
            ['product_id' => 6, 'min_stock' => 15, 'max_stock' => 100, 'reorder_point' => 30, 'seasonal_multiplier' => 1.00],
        ];

        foreach ($reorderConfigs as $config) {
            ReorderPoint::create($config);
        }
    }
}