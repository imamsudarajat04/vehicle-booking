<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\VehicleUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class VehicleUsageController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_usage_history', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name;

        //Check if user has super-admin role or not
        $nameRole = [
            'super-admin' => 'Super Admin',
            'approval' => 'Approval',
        ][$userRole] ?? "Role Not Found";

        if (request()->ajax()) {
            $query = VehicleUsage::with(['vehicle', 'employee'])->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return view('pages.management.vehicle-usages.column.action', compact('item'))->render();
                })
                ->editColumn('employee_id', function ($item) {
                    return $item->employee->name;
                })
                ->editColumn('vehicle_id', function ($item) {
                    return $item->vehicle->name;
                })
                ->editColumn('status', function ($item) {
                    if($item->status == 'on-duty') {
                        return '<span class="badge rounded-pill bg-success">On Duty</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-danger">Off Duty</span>';
                    }
                })
                ->rawColumns(['action', 'employee_id', 'vehicle_id', 'status'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.vehicle-usages.index', [
            'nameRole' => $nameRole,
        ]);
    }

    /**
     * Off duty the vehicle
     */
    public function offDuty($id)
    {
        $vehicleUsage = VehicleUsage::findOrFail($id);
        $vehicleUsage->status = 'off-duty';
        $vehicleUsage->save();

        Alert::success('Success', 'Vehicle has been off duty');

        return redirect()->route('vehicle-usage.index');
    }
}
