<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\ReorderController;

Route::apiResource('products', ProductController::class);

Route::get('alerts', [AlertController::class, 'index']);
Route::patch('alerts/{id}/resolve', [AlertController::class, 'resolve']);
Route::post('alerts/run-health-check', [AlertController::class, 'runHealthCheck']);

Route::get('reorder-points', [ReorderController::class, 'index']);
Route::post('reorder-points', [ReorderController::class, 'store']);
Route::get('reorder-points/{productId}/calculate', [ReorderController::class, 'calculate']);