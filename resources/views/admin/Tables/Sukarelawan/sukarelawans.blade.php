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
                                <th>Verification Status</th>
                                <th>Level</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>National Identity Number</th>
                                <th>National Identity Card Image Url</th>
                                <th>Profile Image Url</th>
                                <th>Experience Point</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sukarelawans as $sukarelawan)
                                <tr>
                                    <td>{{ $sukarelawan->id }}</a></td>
                                    <td>{{ $sukarelawan->user->name }}</td>
                                    <td>{{ $sukarelawan->verificationStatus->name }}</td>
                                    <td>{{ $sukarelawan->level->name }}</td>
                                    <td>{{ $sukarelawan->gender }}</td>
                                    <td>{{ $sukarelawan->dateOfBirth }}</td>
                                    <td>{{ $sukarelawan->nationalIdentityNumber }}</td>
                                    <td>{{ $sukarelawan->nationalIdentityCardImageUrl !== null ? $sukarelawan->nationalIdentityCardImageUrl : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->profileImageUrl !== null ? $sukarelawan->profileImageUrl : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->experiencePoint }}</td>
                                    <td>{{ $sukarelawan->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/sukarelawans/{{ $sukarelawan->slug }}">
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
