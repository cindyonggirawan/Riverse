@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <!-- /.Card Body-->
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Id</dt>
                        <dd class="col-sm-8">{{ $role->id }}</dd>

                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $role->name }}</dd>

                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $role->slug }}</dd>

                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $role->created_at }}</dd>

                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $role->updated_at }}</dd>
                    </dl>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-default">
                        <i class="fas fa-angle-left">
                        </i>
                        Back
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
