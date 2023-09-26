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
                                <th>City</th>
                                <th>Name</th>
                                <th>Location Url</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rivers as $river)
                                <tr>
                                    <td>{{ $river->id }}</a></td>
                                    <td>{{ $river->city->name }}</a></td>
                                    <td>{{ $river->name }}</td>
                                    <td>{{ $river->locationUrl }}</td>
                                    <td>{{ $river->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/rivers/{{ $river->slug }}">
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
