<?php

namespace App\Http\Controllers\Dashboard\DataMaster;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    // Constructor
    public function __construct()
    {
        $this->middleware('auth'); // Check if user is logged in
        $this->middleware('permission:view_roles|create_roles|edit_roles|delete_roles', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy']]);
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
            $query = Role::with('permissions');

            $user = Auth()->user();
            return DataTables::of($query)
                ->addColumn('action', function ($item) use ($user) {
                    return view('pages.data-master.roles.columns.action', compact('item', 'user'))->render();
                })
                ->editColumn('permissions', function ($item) {
                    return view('pages.data-master.roles.columns.permission', compact('item'))->render();
                })
                ->rawColumns(['action', 'permissions'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.data-master.roles.index', [
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

        $permissions = Permission::all();
        return view('pages.data-master.roles.create', [
            'nameRole'    => $nameRole,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255|unique:roles,name',
            'permission'  => 'required',
        ], [
            'name.required'        => 'The role field is required.',
            'name.string'          => 'The role field must be a string.',
            'name.max'             => 'The role field must be less than 255 characters.',
            'name.unique'          => 'The role field has already been taken.',
            'permission.required'  => 'The permissions field is required.',
        ]);

        $role = Role::create(['name' => $request->name]);
        $permissions = $request->input('permission');

        $permissions = array_map(function ($item) {
            return (int)$item;
        }, $permissions);

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        Alert::success('Success', 'Role has been created');
        return redirect()->route('role.index');
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

        $data = Role::findOrFail($id);
        $permissions = Permission::all();
        $data->load('permissions');

        if($userRole != 'super-admin')
        {
            Alert::error('Error', 'You cannot edit this role');
            return redirect()->route('role.index');
        }else{
            return view('pages.data-master.roles.edit', compact('data', 'permissions', 'nameRole'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255|unique:roles,name, ' . $id . ',id',
            'permission'  => 'required',
        ], [
            'name.required'        => 'The role field is required.',
            'name.string'          => 'The role field must be a string.',
            'name.max'             => 'The role field must be less than 255 characters.',
            'name.unique'          => 'The role field has already been taken.',
            'permission.required'  => 'The permissions field is required.',
        ]);

        $data = Role::findOrFail($id);
        $data->update(['name' => $request->name]);
        $data->permissions()->sync($request->input('permission', []));

        Alert::success('Success', 'Role has been updated');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Role::findOrFail($id);
        if($data->id == 1)
        {
            return response()->json([
                'status' => 403,
                'message' => 'You cannot delete this role',
            ]);
        }elseif(empty($data)){
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ]);
        }else{
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data has been deleted',
            ]);
        }
    }
}
