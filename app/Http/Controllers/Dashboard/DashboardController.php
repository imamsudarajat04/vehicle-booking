<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\VehicleUsage;
use Chartisan\PHP\Chartisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Chart as ChartChart;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name;

        $nameRole = [
            'super-admin' => 'Super Admin',
            'approval' => 'Approval',
        ][$userRole] ?? "Role Not Found";

        $vehicleUsages = VehicleUsage::where('status', 'on-duty')->count();
        
        return view('pages.dashboard.index', [
            'nameRole' => $nameRole,
            'vehicleUsages' => $vehicleUsages,
        ]);
    }
}