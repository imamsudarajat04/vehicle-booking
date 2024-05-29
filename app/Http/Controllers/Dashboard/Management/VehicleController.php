<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Office;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class VehicleController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_vehicles|create_vehicles|edit_vehicles|delete_vehicles', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_vehicles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_vehicles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_vehicles', ['only' => ['destroy']]);
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

        if(request()->ajax()) {
            $query = Vehicle::with('office')->get();

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return view('pages.management.vehicles.column.action', compact('item'))->render();
                })
                ->editColumn('type', function($item) {
                    return $item->type == 'passenger' ? 'Passenger' : 'Cargo';
                })
                ->editColumn('ownership', function($item) {
                    return $item->ownership == 'company_owned' ? 'Company Owned' : 'Rental';
                })
                ->editColumn('office_id', function($item) {
                    return $item->office->name;
                })
                ->rawColumns(['action', 'type', 'office_id'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.vehicles.index', [
            'nameRole' => $nameRole,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name;

        //Check if user has super-admin role or not
        $nameRole = [
            'super-admin' => 'Super Admin',
            'approval' => 'Approval',
        ][$userRole] ?? "Role Not Found";

        $offices = Office::all();

        return view('pages.management.vehicles.create', [
            'nameRole' => $nameRole,
            'offices'  => $offices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|string',
            'type'         => 'required|in:passenger,cargo',
            'ownership'    => 'required|in:company_owned,rental',
            'brand'        => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|numeric',
            'plate_number' => 'required|string',
            'capacity'     => 'required|numeric',
            'office_id'    => 'required|exists:offices,id',
        ], [
            'name.required'         => 'The vehicle name field is required.',
            'name.string'           => 'The vehicle name field must be a string.',
            'type.required'         => 'The vehicle type field is required.',
            'type.in'               => 'The vehicle type field must be passenger or cargo.',
            'ownership.required'    => 'The vehicle ownership field is required.',
            'ownership.in'          => 'The vehicle ownership field must be company owned or rental.',
            'brand.required'        => 'The vehicle brand field is required.',
            'brand.string'          => 'The vehicle brand field must be a string.',
            'model.required'        => 'The vehicle model field is required.',
            'model.string'          => 'The vehicle model field must be a string.',
            'year.required'         => 'The vehicle year field is required.',
            'year.numeric'          => 'The vehicle year field must be a number.',
            'plate_number.required' => 'The vehicle plate number field is required.',
            'plate_number.string'   => 'The vehicle plate number field must be a string.',
            'capacity.required'     => 'The vehicle capacity field is required.',
            'capacity.numeric'      => 'The vehicle capacity field must be a number.',
            'office_id.required'    => 'The office field is required.',
            'office_id.exists'      => 'The selected office is invalid.',
        ]);

        Vehicle::create($request->all());

        Alert::success('Success', 'Vehicle has been added.');
        return redirect()->route('vehicle.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name;

        //Check if user has super-admin role or not
        $nameRole = [
            'super-admin' => 'Super Admin',
            'approval' => 'Approval',
        ][$userRole] ?? "Role Not Found";

        $offices = Office::all();

        $data = Vehicle::findOrFail($id);

        return view('pages.management.vehicles.edit', [
            'nameRole' => $nameRole,
            'data'     => $data,
            'offices'  => $offices,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'         => 'required|string',
            'type'         => 'required|in:passenger,cargo',
            'ownership'    => 'required|in:company_owned,rental',
            'brand'        => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|numeric',
            'plate_number' => 'required|string',
            'capacity'     => 'required|numeric',
            'office_id'    => 'required|exists:offices,id',
        ], [
            'name.required'         => 'The vehicle name field is required.',
            'name.string'           => 'The vehicle name field must be a string.',
            'type.required'         => 'The vehicle type field is required.',
            'type.in'               => 'The vehicle type field must be passenger or cargo.',
            'ownership.required'    => 'The vehicle ownership field is required.',
            'ownership.in'          => 'The vehicle ownership field must be company owned or rental.',
            'brand.required'        => 'The vehicle brand field is required.',
            'brand.string'          => 'The vehicle brand field must be a string.',
            'model.required'        => 'The vehicle model field is required.',
            'model.string'          => 'The vehicle model field must be a string.',
            'year.required'         => 'The vehicle year field is required.',
            'year.numeric'          => 'The vehicle year field must be a number.',
            'plate_number.required' => 'The vehicle plate number field is required.',
            'plate_number.string'   => 'The vehicle plate number field must be a string.',
            'capacity.required'     => 'The vehicle capacity field is required.',
            'capacity.numeric'      => 'The vehicle capacity field must be a number.',
            'office_id.required'    => 'The office field is required.',
            'office_id.exists'      => 'The selected office is invalid.',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        Alert::success('Success', 'Vehicle has been updated.');
        return redirect()->route('vehicle.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if(!empty($vehicle))
        {
            $vehicle->delete();
            return response()->json([
                'status'  => 200,
                'message' => 'Vehicle has been deleted.',
            ]);
        }else{
            return response()->json([
                'status'  => 404,
                'message' => 'Vehicle not found.',
            ]);
        }
    }
}
