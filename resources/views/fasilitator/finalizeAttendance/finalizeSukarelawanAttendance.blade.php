@extends('layout.index')

@section('css')
{{-- @include('layout.useBootstrap') --}}
<link rel="stylesheet" href="{{ asset('/css/finalizeSukarelawanAttendance.css') }}"/>
@endsection

@section('content')
    <div class="content-wrapper">
        <h1 class="page-title">Kelola Sukarelawan</h1>
        <!-- Main content -->
        <section class="content">
            <!-- Container Fluid -->
            <div class="container-fluid">
                <!-- Row -->
                @yield('Fasilitator.finalizeAttendance')
                <!-- /.row -->
            </div>
            <!-- /.container fluid -->
        </section>
        <!-- /.main content -->
    </div>
@endsection
