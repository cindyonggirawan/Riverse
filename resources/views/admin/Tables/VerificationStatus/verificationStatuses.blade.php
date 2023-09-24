@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($verificationStatuses as $verificationStatus)
                                <tr>
                                    <td>{{ $verificationStatus->id }}</a></td>
                                    <td>{{ $verificationStatus->name }}</td>
                                    <td>{{ $verificationStatus->created_at }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                            href="/verification-statuses/{{ $verificationStatus->slug }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
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
