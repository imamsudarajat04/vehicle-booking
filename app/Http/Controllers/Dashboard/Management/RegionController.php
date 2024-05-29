<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class RegionController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_regions|create_regions|delete_regions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_regions', ['only' => ['create', 'store']]);
        $this->middleware('permission:delete_regions', ['only' => ['destroy']]);
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
            $query = Region::all();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return view('pages.management.regions.column.action', compact('item'))->render();
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.management.regions.index', [
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

        return view('pages.management.regions.create', [
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
        ], [
            'name.required' => 'The region field is required.',
            'name.string'   => 'The region field must be a string.',
            'name.max'      => 'The region field must be less than 255 characters.',
        ]);

        Region::create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Region has been created');
        return redirect()->route('region.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Region::findOrFail($id);
        
        if(!empty($data))
        {
            $data->delete();
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
