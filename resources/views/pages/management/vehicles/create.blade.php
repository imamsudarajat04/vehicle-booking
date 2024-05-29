@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Vehicle')
@section('pageTitle', 'Vehicle')
@section('management', 'active')
@section('toggleManagement', '')
@section('vehicle', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Vehicle</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Create Vehicle</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('vehicle.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('vehicle.store') !!}" method="POST">
          @csrf
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Mine Name" class="form-label">Vehicle Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}" placeholder="Insert Vehicle Name...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Type Vehicle" class="form-label">Type Vehicle</label>
                <select class="form-select" name="type" id="type">
                    <option value="" selected disabled>-- Choose Type --</option>
                    <option value="passenger">Passenger</option>
                    <option value="cargo">Cargo</option>
                </select>

                @error('type')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Ownership" class="form-label">Ownership</label>
                <select class="form-select" name="ownership" id="ownership">
                    <option value="" selected disabled>-- Choose Ownership --</option>
                    <option value="company_owned">Company</option>
                    <option value="rental">Rental</option>
                </select>

                @error('ownership')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Brand" class="form-label">Vehicle Brand</label>
                <input type="text" class="form-control" name="brand" id="brand" value="{!! old('brand') !!}" placeholder="Insert Vehicle Brand...">

                @error('brand')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Model" class="form-label">Vehicle Model</label>
                <input type="text" class="form-control" name="model" id="model" value="{!! old('model') !!}" placeholder="Insert Vehicle Model...">

                @error('model')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Vehicle Year" class="form-label">Vehicle Year</label>
                <input type="text" class="form-control" name="year" id="year" value="{!! old('year') !!}" placeholder="Insert Vehicle Year...">

                @error('year')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="Plat Number" class="form-label">Plate Number</label>
                <input type="text" class="form-control" name="plate_number" id="plate_number" value="{!! old('plate_number') !!}" placeholder="Insert Plate Number...">

                @error('plate_number')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="Capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" name="capacity" id="capacity" value="{!! old('capacity') !!}" placeholder="Insert Capacity...">

                    @error('capacity')
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
                        <option value="{!! $office->id !!}">{!! $office->name !!}</option>
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
              <button class="btn btn-primary" type="submit"><i class="bx bx-plus-medical"></i> Insert Vehicle</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection