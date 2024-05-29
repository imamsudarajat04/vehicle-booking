@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Region')
@section('pageTitle', 'Region')
@section('management', 'active')
@section('toggleManagement', '')
@section('region', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Region</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Create Region</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('region.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('region.store') !!}" method="POST">
          @csrf
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Region Name" class="form-label">Region</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}" placeholder="Insert Region...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bx-plus-medical"></i> Insert Region</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection