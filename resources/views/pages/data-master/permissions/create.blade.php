@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Permission')
@section('pageTitle', 'Permission')
@section('datamaster', 'active')
@section('toggle', '')
@section('permission', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Permission</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Create Permission</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('permission.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('permission.store') !!}" method="POST">
          @csrf
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="Permission" class="form-label">Permission</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}" placeholder="Insert Permission...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bx-plus-medical"></i> Insert Permission</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection