@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitatorTypes as $fasilitatorType)
                                <tr>
                                    <td>{{ $fasilitatorType->id }}</a></td>
                                    <td>{{ $fasilitatorType->name }}</td>
                                    <td>{{ $fasilitatorType->created_at }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-primary btn-sm btn-square"
                                                href="/fasilitator-types/{{ $fasilitatorType->slug }}">
                                                <i class="fas fa-folder">
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
