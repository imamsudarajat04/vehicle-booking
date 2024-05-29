<?php

namespace App\Http\Controllers\Dashboard\Booking;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Approval;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    // Constructor
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_bookings|create_bookings|edit_bookings|delete_bookings', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_bookings', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_bookings', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_bookings', ['only' => ['destroy']]);
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
            $query = Booking::with('vehicle')->with('employee')->with('user')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return view('pages.bookings.column.action', compact('item'))->render();
                })
                ->editColumn('booking_date', function ($item) {
                    return Carbon::parse($item->booking_date)->format('d F Y H:i');
                })
                ->editColumn('usage_start', function ($item) {
                    return Carbon::parse($item->usage_start)->format('d F Y H:i');
                })
                ->editColumn('usage_end', function ($item) {
                    return Carbon::parse($item->usage_end)->format('d F Y H:i');
                })
                ->editColumn('status', function ($item) {
                    if($item->status == 'pending') {
                        return '<span class="badge rounded-pill bg-warning">Pending</span>';
                    } elseif($item->status == 'approved') {
                        return '<span class="badge rounded-pill bg-success">Approved</span>';
                    } elseif($item->status == 'rejected') {
                        return '<span class="badge rounded-pill bg-danger">Rejected</span>';
                    }
                    
                })
                ->editColumn('vehicle_id', function ($item) {
                    return $item->vehicle->name;
                })
                ->editColumn('employee_id', function ($item) {
                    return $item->employee->name;
                })
                ->editColumn('user_id', function ($item) {
                    return $item->user->name;
                })
                ->rawColumns(['action', 'status', 'booking_date', 'usage_start', 'usage_end', 'user_id', 'vehicle_id', 'employee_id'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.bookings.index', [
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
        
        $users = User::role('approval')->get();
        $employees = Employee::all();
        $vehicles = Vehicle::all();

        return view('pages.bookings.create', [
            'nameRole'  => $nameRole,
            'vehicles'  => $vehicles,
            'employees' => $employees,
            'users'     => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id'   => 'required|exists:employees,id',
            'vehicle_id'    => 'required|exists:vehicles,id',
            'user_id'       => 'required|exists:users,id',
            'booking_date'  => 'required',
            'usage_start'   => 'required',
            'usage_end'     => 'required',
        ], [
            'employee_id.required'  => 'The employee field is required.',
            'vehicle_id.required'   => 'The vehicle field is required.',
            'user_id.required'      => 'The user field is required.',
            'booking_date.required' => 'The booking date field is required.',
            'usage_start.required'  => 'The usage start field is required.',
            'usage_end.required'    => 'The usage end field is required.',
        ]);

        $booking = Booking::create([
            'employee_id'   => $request->employee_id,
            'vehicle_id'    => $request->vehicle_id,
            'user_id'       => $request->user_id,
            'booking_date'  => $request->booking_date,
            'usage_start'   => $request->usage_start,
            'usage_end'     => $request->usage_end,
            'status'        => 'pending',
        ]);

        Alert::success('Success', 'Booking has been created');
        return redirect()->route('booking.index');
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

        $booking = Booking::findOrFail($id);

        $users = User::role('approval')->get();
        $employees = Employee::all();
        $vehicles = Vehicle::all();

        return view('pages.bookings.edit', [
            'nameRole'  => $nameRole,
            'booking'   => $booking,
            'vehicles'  => $vehicles,
            'employees' => $employees,
            'users'     => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'employee_id'   => 'required|exists:employees,id',
            'vehicle_id'    => 'required|exists:vehicles,id',
            'user_id'       => 'required|exists:users,id',
            'booking_date'  => 'required',
            'usage_start'   => 'required',
            'usage_end'     => 'required',
        ], [
            'employee_id.required'  => 'The employee field is required.',
            'vehicle_id.required'   => 'The vehicle field is required.',
            'user_id.required'      => 'The user field is required.',
            'booking_date.required' => 'The booking date field is required.',
            'usage_start.required'  => 'The usage start field is required.',
            'usage_end.required'    => 'The usage end field is required.',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update([
            'employee_id'   => $request->employee_id,
            'vehicle_id'    => $request->vehicle_id,
            'user_id'       => $request->user_id,
            'booking_date'  => $request->booking_date,
            'usage_start'   => $request->usage_start,
            'usage_end'     => $request->usage_end,
            'status'        => $booking->status,
        ]);

        Alert::success('Success', 'Booking has been updated');
        return redirect()->route('booking.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        if(!empty($booking))
        {
            $booking->delete();
            return response()->json([
                'status'  => 200,
                'message' => 'Booking has been deleted',
            ]);
        }else{
            return response()->json([
                'status'  => 404,
                'message' => 'Booking not found',
            ]);
        }
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        if($booking->status == 'approved' || $booking->status == 'rejected') {
            Alert::error('Error', 'Booking has been approved or rejected');
            return redirect()->route('booking.index');
        }

        $booking->update([
            'status' => 'approved',
        ]);

        $approval = Approval::create([
            'booking_id' => $booking->id,
            'user_id'    => Auth::id(),
            'status'     => 'approved',
        ]);

        Alert::success('Success', 'Booking has been approved');
        return redirect()->route('booking.index');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status == 'approved' || $booking->status == 'rejected') {
            Alert::error('Error', 'Booking has been approved or rejected');
            return redirect()->route('booking.index');
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        $approval = Approval::create([
            'booking_id' => $booking->id,
            'user_id'    => Auth::id(),
            'status'     => 'rejected',
        ]);

        Alert::success('Success', 'Booking has been rejected');
        return redirect()->route('booking.index');
    }
}
