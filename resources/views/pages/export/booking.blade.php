@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Export Booking')
@section('pageTitle', 'Export Booking')
@section('booking-export', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Export Booking</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Export Periodic Report</h5>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('booking.export') }}" method="GET">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection