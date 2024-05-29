@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Booking')
@section('pageTitle', 'Booking')
@section('booking', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Booking</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Edit Booking</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('booking.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('booking.update', $booking->id) !!}" method="POST">

          @csrf
          @method('PUT')
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Employee" class="form-label">Employee Name</label>
                <select name="employee_id" id="employee_id" class="form-select">
                    <option value="" selected disabled>-- Choose Employee Name --</option>
                    @foreach ($employees as $employee)
                        <option value="{!! $employee->id !!}" {!! $booking->employee_id == $employee->id ? 'selected' : '' !!}>{!! $employee->name !!}</option>
                    @endforeach
                </select>

                @error('employee_id')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Vehicle Name" class="form-label">Vehicle Name</label>
                <select name="vehicle_id" id="vehicle_id" class="form-select">
                    <option value="" selected disabled>-- Choose Vehicle Name --</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{!! $vehicle->id !!}" {!! $booking->vehicle_id == $vehicle->id ? 'selected' : '' !!}>{!! $vehicle->name !!}</option>
                    @endforeach
                </select>

                @error('vehicle_id')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Approval Name" class="form-label">Approval Name</label>
                <select name="user_id" id="user_id" class="form-select">
                    <option value="" selected disabled>-- Choose Approval Name --</option>
                    @foreach ($users as $user)
                        <option value="{!! $user->id !!}" {!! $booking->user_id == $user->id ? 'selected' : '' !!}>{!! $user->name !!}</option>
                    @endforeach
                </select>

                @error('user_id')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Booking Date" class="form-label">Booking Date</label>
                <input type="datetime-local" class="form-control" name="booking_date" id="booking_date" value="{{ old('booking_date', $booking->booking_date) }}">

                @error('booking_date')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Usage Start" class="form-label">Usage Start</label>
                <input type="datetime-local" class="form-control" name="usage_start" id="usage_start" value="{{ old('usage_start', $booking->usage_start) }}">

                @error('usage_start')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Usage End" class="form-label">Usage End</label>
                <input type="datetime-local" class="form-control" name="usage_end" id="usage_end" value="{{ old('usage_end', $booking->usage_end) }}">

                @error('usage_end')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bxs-edit"></i> Update Booking</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection