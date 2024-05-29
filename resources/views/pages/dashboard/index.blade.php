@extends('layouts.dashboard.DashboardLayout')

@section('title', 'Dashboard')
@section('dashboard', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="row">
    <div class="col">

        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Hello, {!! Auth::user()->name !!}!</h4>
                        </div>
                    </div><!-- end card header -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div> <!-- end .h-100-->

    </div> <!-- end col -->
</div>
@endsection