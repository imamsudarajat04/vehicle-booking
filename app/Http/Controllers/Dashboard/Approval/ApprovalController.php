<?php

namespace App\Http\Controllers\Dashboard\Approval;

use App\Models\Approval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ApprovalController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_approvals|delete_approvals', ['only' => ['index', 'store']]);
        $this->middleware('permission:delete_approvals', ['only' => ['destroy']]);
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
            $query = Approval::with('booking', 'user')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return view('pages.approvals.column.action', compact('item'))->render();
                })
                ->editColumn('user_id', function ($item) {
                    return $item->user->name;
                })
                ->editColumn('status', function ($item) {
                    if($item->status == 'rejected') {
                        return '<span class="badge rounded-pill bg-danger">Rejected</span>';
                    }else{
                        return '<span class="badge rounded-pill bg-success">Approved</span>';
                    }
                })
                ->rawColumns(['action', 'user_id', 'status'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.approvals.index', [
            'nameRole' => $nameRole,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $approval = Approval::findOrFail($id);

        if(!empty($approval))
        {
            $approval->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data has been deleted successfully'
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data not found'
            ]);
        }
    }
}
