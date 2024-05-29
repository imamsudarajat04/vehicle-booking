@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Mine')
@section('pageTitle', 'Mine')
@section('management', 'active')
@section('toggleManagement', '')
@section('mine', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Mine</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Create Mine</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('mine.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('mine.store') !!}" method="POST">
          @csrf
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Mine Name" class="form-label">Mine Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}" placeholder="Insert Mine Name...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <textarea class="form-control" name="address" id="address" cols="30" rows="4" placeholder="Insert Office Address..."></textarea>

                @error('address')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Region" class="form-label">Region</label>
                <select name="region_id" id="region_id" class="form-select">
                    <option value="" selected disabled>-- Choose Region --</option>
                    @foreach ($regions as $region)
                        <option value="{!! $region->id !!}">{!! $region->name !!}</option>
                    @endforeach
                </select>

                @error('region_id')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bx-plus-medical"></i> Insert Mine</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection