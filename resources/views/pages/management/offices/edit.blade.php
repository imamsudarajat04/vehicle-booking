@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Office')
@section('pageTitle', 'Office')
@section('management', 'active')
@section('toggleManagement', '')
@section('office', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Office</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Edit Office</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('office.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('office.update', $data->id) !!}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="Office Name" class="form-label">Office Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name', $data->name) !!}" placeholder="Insert Office Name...">

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
                <textarea class="form-control" name="address" id="address" cols="30" rows="4" placeholder="Insert Office Address...">{!! old('address', $data->address) !!}</textarea>

                @error('address')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="" selected disabled>-- Choose Type --</option>
                    <option value="head_office" {!! $data->type == 'head_office' ? 'selected' : '' !!}>Head Office</option>
                    <option value="branch_office" {!! $data->type == 'branch_office' ? 'selected' : '' !!}>Branch Office</option>
                </select>

                @error('type')
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
                        <option value="{!! $region->id !!}" {!! $data->region_id == $region->id ? 'selected' : '' !!}>{!! $region->name !!}</option>
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
              <button class="btn btn-primary" type="submit"><i class="bx bxs-edit"></i> Update Office</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection