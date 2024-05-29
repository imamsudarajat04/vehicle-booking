<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Office;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_offices|create_offices|edit_offices|delete_offices', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_offices', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_offices', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_offices', ['only' => ['destroy']]);
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
            $query = Office::with('region')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return view('pages.management.offices.column.action', compact('item'))->render();
                })
                ->editColumn('type', function ($item) {
                    return $item->type == 'head_office' ? 'Head Office' : 'Branch Office';
                })
                ->editColumn('region_id', function ($item) {
                    return $item->region->name;
                })
                ->rawColumns(['action', 'type', 'region_id'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.offices.index', [
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

        $regions = Region::all();

        return view('pages.management.offices.create', [
            'nameRole' => $nameRole,
            'regions'  => $regions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:255',
            'address'   => 'required|string',
            'type'      => 'required|in:head_office,branch_office',
            'region_id' => 'required|exists:regions,id',
        ], [
            'name.required'      => 'Name is required',
            'name.string'        => 'Name must be a string',
            'name.max'           => 'Name max 255 characters',
            'address.required'   => 'Address is required',
            'address.string'     => 'Address must be a string',
            'type.required'      => 'Type is required',
            'type.in'            => 'Type must be Head Office or Branch Office',
            'region_id.required' => 'Region is required',
            'region_id.exists'   => 'Region not found',
        ]);

        $data = $request->all();
        Office::create($data);

        Alert::success('Success', 'Office has been added');
        return redirect()->route('office.index');
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

        $data = Office::findOrFail($id);

        $regions = Region::all();

        return view('pages.management.offices.edit', [
            'nameRole' => $nameRole,
            'data'     => $data,
            'regions'  => $regions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:255',
            'address'   => 'required|string',
            'type'      => 'required|in:head_office,branch_office',
            'region_id' => 'required|exists:regions,id',
        ], [
            'name.required'      => 'Name is required',
            'name.string'        => 'Name must be a string',
            'name.max'           => 'Name max 255 characters',
            'address.required'   => 'Address is required',
            'address.string'     => 'Address must be a string',
            'type.required'      => 'Type is required',
            'type.in'            => 'Type must be Head Office or Branch Office',
            'region_id.required' => 'Region is required',
            'region_id.exists'   => 'Region not found',
        ]);

        $office = Office::findOrFail($id);
        $office->update($request->all());

        Alert::success('Success', 'Office has been updated');
        return redirect()->route('office.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $office = Office::findOrFail($id);

        if(!empty($office))
        {
            $office->delete();
            return response()->json([
                'status'  => 200,
                'message' => 'Office has been deleted',
            ]);
        }else{
            return response()->json([
                'status'  => 404,
                'message' => 'Office not found',
            ]);
        }
    }
}
