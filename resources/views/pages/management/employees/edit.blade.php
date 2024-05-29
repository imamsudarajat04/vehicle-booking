@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Employee')
@section('pageTitle', 'Employee')
@section('management', 'active')
@section('toggleManagement', '')
@section('employee', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Employee</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Edit Employee</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('employee.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('employee.update', $employee->id) !!}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Employee Name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name', $employee->name) !!}" placeholder="Insert Employee Name...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Position" class="form-label">Position</label>
                <input type="text" class="form-control" name="position" id="position" value="{!! old('position', $employee->position) !!}" placeholder="Insert Position Name...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Office" class="form-label">Office</label>
                <select name="office_id" id="office_id" class="form-select">
                    <option value="" selected disabled>-- Choose Office --</option>
                    @foreach ($offices as $office)
                        <option value="{!! $office->id !!}" {!! $employee->office_id == $office->id ? 'selected' : '' !!}>{!! $office->name !!}</option>
                    @endforeach
                </select>

                @error('office_id')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bxs-edit"></i> Update Employee</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection