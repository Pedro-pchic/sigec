<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Services\ManagementDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, ManagementDashboardService $managementDashboard): View
    {
        if (! $request->user()?->can('view-management-dashboard')) {
            return view('dashboard', [
                'totalUsers' => User::count(),
                'activeUsers' => User::where('is_active', true)->count(),
                'totalEmployees' => Employee::count(),
                'activeEmployees' => Employee::where('is_active', true)->count(),
                'isManagementDashboard' => false,
            ]);
        }

        $filters = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);
        $from = $filters['from'] ?? today()->startOfMonth()->toDateString();
        $to = $filters['to'] ?? today()->toDateString();

        return view('dashboard', [
            'dashboardMetrics' => $managementDashboard->dashboard($from, $to),
            'from' => $from,
            'to' => $to,
            'isManagementDashboard' => true,
        ]);
    }
}
