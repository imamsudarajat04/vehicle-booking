@extends('layouts.dashboard.DashboardLayout')

@section('title', 'User')
@section('pageTitle', 'User')
@section('datamaster', 'active')
@section('toggle', '')
@section('user', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">User</li>
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
          <h5 class="card-title mb-0 flex-grow-1">List Users</h5>

          @can('create_users')  
            <div class="flex-shrink-0">
              <a class="btn btn-success add-btn" href="{!! route('user.create') !!}"> <i class="ri-add-line align-bottom me-1"></i> Create new user</a>
            </div>
          @endcan
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="tableUser">
            <thead>
              <tr>
                <th style="width: 70px">No</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ROLE</th>
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
         var tableUser = $('#tableUser').DataTable({
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
                data: 'name',
                name: 'name',
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'role',
                name: 'role',
                orderable: false,
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
            $(nRow).attr('id', 'user' + data.id);
            },
        });

        $(document).on('click', '#btn-hapus', function () {
            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: `/data-master/user/${id}`,
                    type: 'DELETE',
                    cache: false,
                    data: {
                    _token: token
                    },
                    success: function(res) {
                    if(res.status == 200) {
                        Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${res.message}`,
                        showConfirmButton: false,
                        timer: 3000
                        });

                        $('#user' + id).remove();
                        $('#tableUser').DataTable().ajax.reload();
                        $('#tableUser').DataTable().draw();
                    }else if(res.status == 403){
                        Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: `${res.message}`,
                        showConfirmButton: false,
                        timer: 3000
                        });
                    }else{
                        Swal.fire({
                        type: 'info',
                        icon: 'info',
                        title: `${res.message}`,
                        showConfirmButton: false,
                        timer: 3000
                        });
                    }
                    },
                    error: function(e) {
                    console.log(e.message);
                    }
                })
                }
            })
        });
    </script>
@endpush