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
                                <th>Verification Status Id</th>
                                <th>Fasilitator Type Id</th>
                                <th>Description</th>
                                <th>Logo Image Url</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitators as $fasilitator)
                                <tr>
                                    <td>{{ $fasilitator->id }}</a></td>
                                    <td>{{ $fasilitator->verificationStatusId }}</td>
                                    <td>{{ $fasilitator->fasilitatorTypeId }}</td>
                                    <td>{{ Str::words($fasilitator->description, 5) }}</td>
                                    <td>{{ $fasilitator->logoImageUrl !== null ? $fasilitator->logoImageUrl : '-' }}</td>
                                    <td>{{ Str::words($fasilitator->address, 5) }}</td>
                                    <td>{{ $fasilitator->phoneNumber }}
                                    </td>
                                    <td>{{ $fasilitator->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/fasilitators/{{ $fasilitator->slug }}">
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
