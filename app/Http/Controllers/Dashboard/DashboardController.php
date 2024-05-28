<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
        
        return view('pages.dashboard.index', [
            'nameRole' => $nameRole,
        ]);
    }
}