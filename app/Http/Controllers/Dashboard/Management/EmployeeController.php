<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Employee;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPSTORM_META\map;

class EmployeeController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_employees|create_employees|edit_employees|delete_employees', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_employees', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_employees', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_employees', ['only' => ['destroy']]);
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
            $query = Employee::with('office')->get();

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return view('pages.management.employees.column.action', compact('item'))->render();
                })
                ->editColumn('office_id', function($item) {
                    return $item->office->name;
                })
                ->rawColumns(['action', 'office_id'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.employees.index', [
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

        return view('pages.management.employees.create', [
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
            'name'         => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'office_id'    => 'required|exists:offices,id',
        ], [
            'name.required'      => 'Name cannot be empty',
            'name.string'        => 'Name must be a string',
            'name.max'           => 'Name cannot be more than 255 characters',
            'position.required'  => 'Position cannot be empty',
            'position.string'    => 'Position must be a string',
            'position.max'       => 'Position cannot be more than 255 characters',
            'office_id.required' => 'Office cannot be empty',
            'office_id.exists'   => 'Office not found',
        ]);

        Employee::create([
            'name'      => $request->name,
            'position'  => $request->position,
            'office_id' => $request->office_id,
        ]);

        Alert::success('Success', 'Employee has been added');
        return redirect()->route('employee.index');
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

        $employee = Employee::findOrFail($id);
        $offices = Office::all();

        return view('pages.management.employees.edit', [
            'nameRole' => $nameRole,
            'employee' => $employee,
            'offices'  => $offices,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'         => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'office_id'    => 'required|exists:offices,id',
        ], [
            'name.required'      => 'Name cannot be empty',
            'name.string'        => 'Name must be a string',
            'name.max'           => 'Name cannot be more than 255 characters',
            'position.required'  => 'Position cannot be empty',
            'position.string'    => 'Position must be a string',
            'position.max'       => 'Position cannot be more than 255 characters',
            'office_id.required' => 'Office cannot be empty',
            'office_id.exists'   => 'Office not found',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update([
            'name'      => $request->name,
            'position'  => $request->position,
            'office_id' => $request->office_id,
        ]);

        Alert::success('Success', 'Employee has been updated');
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        if(!empty($employee))
        {
            $employee->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Employee has been deleted',
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found',
            ]);
        }
    }
}
