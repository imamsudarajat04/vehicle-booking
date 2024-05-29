@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Role')
@section('pageTitle', 'Role')
@section('datamaster', 'active')
@section('toggle', '')
@section('role', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Role</li>
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
          <h5 class="card-title mb-0 flex-grow-1">List Role</h5>

          @can('create_roles')  
            <div class="flex-shrink-0">
              <a class="btn btn-success add-btn" href="{!! route('role.create') !!}"> <i class="ri-add-line align-bottom me-1"></i> Create new role</a>
            </div>
          @endcan
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="tableRole">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Roles</th>
                <th width="800">Permissions</th>
                <th width="150px">Action</th>
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
        $('#tableRole').DataTable({
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
                data: 'permissions',
                name: 'permissions',
                orderable: false,
                searchable: false,
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
            $(nRow).attr('id', 'role' + data.id);
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
                url: `/data-master/role/${id}`,
                type: 'DELETE',
                cache: false,
                data: {
                    _token: token
                },
                success:function(response){ 
                    if(response.status == 403)
                    {
                    //show danger message
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    }
                    else if(response.status == 404)
                    {
                    //show info message
                    Swal.fire({
                        type: 'info',
                        icon: 'info',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    }
                    else
                    {
                    //show success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // //remove post on table
                    $('#role' + id).remove();
                    $('#tableRole').DataTable().ajax.reload();
                    $('#tableRole').DataTable().draw();
                    }
                },
                error: function(e) {
                    console.log(e.message);
                }
                });
            }
            })
        });
    </script>
@endpush