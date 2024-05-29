@extends('layouts.dashboard.DashboardLayout')

@section('title', 'User')
@section('pageTitle', 'User')
@section('datamaster', 'active')
@section('toggle', '')
@section('user', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Create User</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('user.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('user.store') !!}" method="POST">
          @csrf
          <div class="row">

            <div class="col-12">
              <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}" placeholder="Insert Full Name...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="{!! old('email') !!}" placeholder="Insert Email...">

                @error('email')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Insert Password...">

                @error('password')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="confirmationPassword" class="form-label">Confirmation Password</label>
                <input type="password" class="form-control" name="confirmationPassword" id="confirmationPassword" placeholder="Insert Confirmation Password...">

                @error('confirmationPassword')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Role" class="form-label">Role</label>
                <select class="form-select" name="role" id="role">
                  @foreach ($roles as $r)
                    <option value="{!! $r->name !!}">{!! ($r->name == 'super-admin') ? 'Super Admin' : 'Approval' !!}</option>
                  @endforeach
                </select>

                @error('role')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bx-plus-medical"></i> Insert User</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection