<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Mine;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class MineController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_mines|create_mines|edit_mines|delete_mines', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_mines', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_mines', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_mines', ['only' => ['destroy']]);
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
            $query = Mine::with('region')->get();

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return view('pages.management.mines.column.action', compact('item'))->render();
                })
                ->editColumn('region_id', function($item) {
                    return $item->region->name;
                })
                ->rawColumns(['action', 'region_id'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.mines.index', [
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

        return view('pages.management.mines.create', [
            'nameRole' => $nameRole,
            'regions' => $regions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required|string',
            'address'    => 'required|string',
            'region_id'  => 'required|exists:regions,id',
        ], [
            'name.required'      => 'The name field is required.',
            'name.string'        => 'The name field must be a string.',
            'address.required'   => 'The address field is required.',
            'address.string'     => 'The address field must be a string.',
            'region_id.required' => 'The region field is required.',
            'region_id.exists'   => 'The selected region is invalid.',
        ]);

        Mine::create([
            'name'      => $request->name,
            'address'   => $request->address,
            'region_id' => $request->region_id,
        ]);

        Alert::success('Success', 'Data has been added');
        return redirect()->route('mine.index');
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
        
        $mine = Mine::findOrFail($id);
        $regions = Region::all();

        return view('pages.management.mines.edit', [
            'nameRole' => $nameRole,
            'mine'     => $mine,
            'regions'  => $regions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'       => 'required|string',
            'address'    => 'required|string',
            'region_id'  => 'required|exists:regions,id',
        ], [
            'name.required'      => 'The name field is required.',
            'name.string'        => 'The name field must be a string.',
            'address.required'   => 'The address field is required.',
            'address.string'     => 'The address field must be a string.',
            'region_id.required' => 'The region field is required.',
            'region_id.exists'   => 'The selected region is invalid.',
        ]);

        $mine = Mine::findOrFail($id);
        $mine->update([
            'name'      => $request->name,
            'address'   => $request->address,
            'region_id' => $request->region_id,
        ]);

        Alert::success('Success', 'Data has been updated');
        return redirect()->route('mine.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mine = Mine::findOrFail($id);

        if(!empty($mine))
        {
            $mine->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data has been deleted',
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ]);
        }
    }
}
