@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Vehicle Usage')
@section('pageTitle', 'Vehicle Usage')
@section('management', 'active')
@section('toggleManagement', '')
@section('vehicle-usage', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Vehicle Usage</li>
@endsection

@push('styles')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">

    <div class="card">

      <div class="card-header">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">List Vehicle Usage</h5>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="tableVehicleUsage">
            <thead>
              <tr>
                <th style="width: 70px">No</th>
                <th>Employee Name</th>
                <th>Vehicle Name</th>
                <th>Status</th>
                <th style="width: 100px">Action</th>
              </tr>
            </thead>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
$('#tableVehicleUsage').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      ajax: '{!! url()->current() !!}',
      order: [
          [1, 'asc']
      ],
  columns: [
  {
      data: 'DT_RowIndex',
      name: 'DT_RowIndex',
      width: '1%',
      orderable: false,
      searchable: false,
  },
  {
      data: 'employee_id',
      name: 'employee_id',
  },
  {
      data: 'vehicle_id',
      name: 'vehicle_id',
  },
  {
      data: 'status',
      name: 'status',
  },
  {
      data: 'action',
      name: 'action',
      orderable: false,
      searchable: false,
      width: '1%',
  }
  ],
  sDom: '<"secondBar d-flex flex-w1rap justify-content-between mb-2";f>rt<"bottom"p>',
  "fnCreatedRow": function(nRow, data) {
      $(nRow).attr('id', 'vehicle' + data.id);
  },
});
</script>
@endpush