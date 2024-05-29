<?php

namespace App\Http\Controllers\Dashboard\DataMaster;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_users|create_users|edit_users|delete_users', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy']]);
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
            $query = User::with('roles')->get();

            $user = Auth()->user();

            return DataTables::of($query)
                ->addColumn('action', function ($item) use ($user) {
                    return view('pages.data-master.users.columns.action', compact('item', 'user'))->render();
                })
                ->editColumn('role', function ($item) {
                    $role = $item->roles->first()->name;
                    return view('pages.data-master.users.columns.role', compact('role'))->render();
                })
                ->rawColumns(['action', 'role'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.data-master.users.index', [
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

        $roles = Role::all();
        return view('pages.data-master.users.create', [
            'nameRole' => $nameRole,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|string|min:8',
            'confirmationPassword' => 'required|same:password',
            'role'                 => 'required',
        ], [
            'name.required'     => 'The name field is required.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email must be a valid email address.',
            'email.unique'      => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min'      => 'The password must be at least 8 characters.',
            'confirmationPassword.required' => 'The confirmation password field is required.',
            'role.required'     => 'The role field is required.',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->assignRole($request->role);

        Alert::success('Success', 'User has been created');
        return redirect()->route('user.index');
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

        $roles = Role::all();
        $data = User::with('roles')->findOrFail($id);

        return view('pages.data-master.users.edit', [
            'nameRole' => $nameRole,
            'roles' => $roles,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($request->filled('password'))
        {
            $this->validate($request, [
                'name'                 => 'required|string|max:255',
                'email'                => 'required|email|unique:users,email,' . $id . ',id',
                'password'             => 'string|min:8',
                'confirmationPassword' => 'same:password',
                'role'                 => 'required',
            ], [
                'name.required'             => 'The name field is required.',
                'name.string'               => 'The name must be a string.',
                'name.max'                  => 'The name must be less than 255 characters.',
                'email.required'            => 'The email field is required.',
                'email.email'               => 'The email must be a valid email address.',
                'email.unique'              => 'The email has already been taken.',
                'password.string'           => 'The password must be a string.',
                'password.min'              => 'The password must be at least 8 characters.',
                'confirmationPassword.same' => 'The confirmation password must match the password.',
                'role.required'             => 'The role field is required.',
            ]);
        }else{
            $this->validate($request, [
                'name'                 => 'required|string|max:255',
                'email'                => 'required|email|unique:users,email,' . $id . ',id',
                'role'                 => 'required',
            ], [
                'name.required'             => 'The name field is required.',
                'name.string'               => 'The name must be a string.',
                'name.max'                  => 'The name must be less than 255 characters.',
                'email.required'            => 'The email field is required.',
                'email.email'               => 'The email must be a valid email address.',
                'email.unique'              => 'The email has already been taken.',
                'role.required'             => 'The role field is required.',
            ]);
        }

        $user = User::findOrFail($id);
        $data = $request->all();

        if(!empty($data['password']))
        {
            $data['password'] = Hash::make($request->password);
        }else{
            $data = Arr::except($data, ['password']);
        }

        $user->update($data);
        $user->syncRoles($request->role);

        Alert::success('Success', 'User has been updated');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::with('roles')->findOrFail($id);
        if($data->roles->first()->name == 'super-admin')
        {
            return response()->json([
                'status' => 403,
                'message' => 'You cannot delete this user',
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
