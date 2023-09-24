@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Form -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <a href="/register/sukarelawan"
                                class="btn btn-block bg-primary d-flex align-items-center justify-content-center"
                                style="height: 70vh;">
                                <i class="fas fa-plus-circle">
                                </i>
                                Register as Sukarelawan
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/register/fasilitator"
                                class="btn btn-block bg-info d-flex align-items-center justify-content-center"
                                style="height: 70vh;">
                                <i class="fas fa-plus-circle">
                                </i>
                                Register as Fasilitator
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection
