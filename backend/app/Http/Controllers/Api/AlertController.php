<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Services\AlertService;

class AlertController extends Controller
{
    protected $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function index()
    {
        return response()->json(
            Alert::with('product')
                ->where('is_resolved', false)
                ->orderByRaw("FIELD(severity, 'CRITICAL', 'WARNING', 'INFO')")
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function resolve($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->update([
            'is_resolved' => true,
            'resolved_at' => now(),
            'resolved_by' => 'Admin',
        ]);
        return response()->json(['message' => 'Alert resolved', 'alert' => $alert]);
    }

    public function runHealthCheck()
    {
        $results = $this->alertService->runDailyHealthCheck();
        return response()->json([
            'message' => 'Health check complete',
            'results' => $results,
        ]);
    }
}
