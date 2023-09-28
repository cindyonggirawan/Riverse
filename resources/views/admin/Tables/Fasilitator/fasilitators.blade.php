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
                                <th>Verification Status</th>
                                <th>Fasilitator Type</th>
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
                                    <td>{{ $fasilitator->user->name }}</td>
                                    <td>{{ $fasilitator->verificationStatus->name }}</td>
                                    <td>{{ $fasilitator->fasilitatorType->name }}</td>
                                    <td>{{ Str::words($fasilitator->description, 5) }}</td>
                                    <td>{{ $fasilitator->logoImageUrl !== null ? $fasilitator->logoImageUrl : '-' }}</td>
                                    <td>{{ Str::words($fasilitator->address, 5) }}</td>
                                    <td>{{ $fasilitator->phoneNumber }}
                                    </td>
                                    <td>{{ $fasilitator->updated_at }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-primary btn-sm btn-square"
                                                href="/fasilitators/{{ $fasilitator->slug }}">
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
