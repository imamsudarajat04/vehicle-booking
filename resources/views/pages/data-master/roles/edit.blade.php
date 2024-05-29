@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Role')
@section('pageTitle', 'Role')
@section('datamaster', 'active')
@section('toggle', '')
@section('role', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Role</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
            background-color: #405189;
            border: none;
            color: #fff;
            border-radius: 3px;
            padding: auto;
        }
    </style>
@endpush

@section('content')
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">Edit Role</h5>

          <div class="flex-shrink-0">
            <a class="btn btn-danger add-btn" href="{!! route('role.index') !!}">
              <i class="bx bx-arrow-back"></i>
              Back
            </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <form action="{!! route('role.update', $data->id) !!}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="Role" class="form-label">Role</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! old('name', $data->name) !!}" placeholder="Insert Role...">

                @error('name')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label for="Permission" class="form-label">Permissions</label>
                <select class="js-example-disabled-multi select2" name="permission[]" id="permission" multiple="multiple">
                  @foreach ($permissions as $p)
                    <option value="{!! $p->id !!}" 
                      @foreach ($data->permissions as $pp)  
                        @if ($p->id == $pp->id)
                          {!! 'selected' !!}
                        @elseif (old('permissions[]'))
                          {!! 'selected' !!}
                        @else
                          {{ '' }}
                        @endif
                      @endforeach
                      >{!! $p->name !!}</option>
                  @endforeach
                </select>

                @error('permission.*')
                  <div class="mt-1">
                    <span class="text-danger">{{$message}}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit"><i class="bx bxs-edit"></i> Update Role</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
      $(".js-example-disabled-multi").select2({
        placeholder: "Choose Permission",
        allowClear: true,
        closeOnSelect: false,
      });
    });
</script>
@endpush