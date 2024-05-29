<?php

namespace App\Http\Controllers\Dashboard\DataMaster;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    // Constructor
    public function __construct()
    {
        $this->middleware('auth'); // Check if user is logged in
        $this->middleware('permission:view_permissions|create_permissions|delete_permissions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_permissions', ['only' => ['create', 'store']]);
        $this->middleware('permission:delete_permissions', ['only' => ['destroy']]);
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
            $query = Permission::all();

            $user = Auth()->user();
            return DataTables::of($query)
                ->addColumn('action', function ($item) use ($user) {
                    return view('pages.data-master.permissions.column.action', compact('item', 'user'));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.data-master.permissions.index', [
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

        return view('pages.data-master.permissions.create', [
            'nameRole' => $nameRole,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ],[
            'name.required' => 'Name Permission is required',
            'name.string' => 'Name Permission must be string',
            'name.max' => 'Name Permission max 255 characters',
            'guard_name.required' => 'Guard Name is required',
            'guard_name.string' => 'Guard Name must be string',
            'guard_name.max' => 'Guard Name max 255 characters',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        Alert::success('Success', 'Data has been added');
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Permission::findOrFail($id);

        if(!empty($data)) {
            $data->delete();
            return response()->json([
                'message' => 'Data has been deleted',
                'status'  => 200
            ]);
        } else {
            return response()->json([
                'message' => 'This Permission not found!',
                'status'  => 404,
            ]);
        }
    }
}
