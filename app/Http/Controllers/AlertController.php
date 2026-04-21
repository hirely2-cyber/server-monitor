<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = Alert::with(['alertable'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_resolved', false);
            } elseif ($request->status === 'resolved') {
                $query->where('is_resolved', true);
            }
        }

        // Filter by severity
        if ($request->has('severity') && $request->severity !== 'all') {
            $query->where('severity', $request->severity);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $alerts = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => Alert::count(),
            'active' => Alert::where('is_resolved', false)->count(),
            'resolved' => Alert::where('is_resolved', true)->count(),
            'critical' => Alert::where('is_resolved', false)->where('severity', 'critical')->count(),
            'warning' => Alert::where('is_resolved', false)->where('severity', 'warning')->count(),
            'info' => Alert::where('is_resolved', false)->where('severity', 'info')->count(),
        ];

        return view('alerts', compact('alerts', 'stats'));
    }

    /**
     * Resolve an alert
     */
    public function resolve($id)
    {
        $alert = Alert::findOrFail($id);
        
        $alert->update([
            'is_resolved' => true,
            'resolved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alert resolved successfully',
        ]);
    }

    /**
     * Resolve multiple alerts
     */
    public function resolveMultiple(Request $request)
    {
        $request->validate([
            'alert_ids' => 'required|array',
            'alert_ids.*' => 'exists:alerts,id',
        ]);

        Alert::whereIn('id', $request->alert_ids)
            ->where('is_resolved', false)
            ->update([
                'is_resolved' => true,
                'resolved_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => count($request->alert_ids) . ' alerts resolved successfully',
        ]);
    }

    /**
     * Delete resolved alerts
     */
    public function deleteResolved()
    {
        $count = Alert::where('is_resolved', true)->delete();

        return response()->json([
            'success' => true,
            'message' => $count . ' resolved alerts deleted',
        ]);
    }

    /**
     * Get alert details
     */
    public function show($id)
    {
        $alert = Alert::with(['alertable'])->findOrFail($id);
        
        return response()->json($alert);
    }
}
