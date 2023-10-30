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
                                <th>Profile Image</th>
                                <th>Name</th>
                                <th>Verification Status</th>
                                <th>Level</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>Card Image</th>
                                <th>National Identity Number</th>
                                <th>National Identity Card Image Url</th>
                                <th>Profile Image Url</th>
                                <th>Experience Point</th>
                                <th>Updated At</th>
                                <th><span class="pe-5">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sukarelawans as $sukarelawan)
                                <tr>
                                    <td>{{ $sukarelawan->id }}</a></td>
                                    <td>
                                        @if ($sukarelawan->profileImageUrl !== null)
                                            <img src="{{ asset('storage/' . $sukarelawan->profileImageUrl) }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $sukarelawan->user->name }}</td>
                                    <td>{{ $sukarelawan->verificationStatus->name }}</td>
                                    <td>{{ $sukarelawan->level->name }}</td>
                                    <td>{{ $sukarelawan->gender }}</td>
                                    <td>{{ $sukarelawan->dateOfBirth }}</td>
                                    <td>
                                        @if ($sukarelawan->nationalIdentityCardImageUrl !== null)
                                            <img src="{{ asset('storage/' . $sukarelawan->nationalIdentityCardImageUrl) }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Sukarelawan/nationalIdentityCardImages/default.png') }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $sukarelawan->nationalIdentityNumber }}</td>
                                    <td>{{ $sukarelawan->nationalIdentityCardImageUrl !== null ? $sukarelawan->nationalIdentityCardImageUrl : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->profileImageUrl !== null ? $sukarelawan->profileImageUrl : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->experiencePoint }}</td>
                                    <td>{{ $sukarelawan->updated_at }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-primary btn-sm btn-square"
                                                href="/sukarelawans/{{ $sukarelawan->slug }}">
                                                <i class="fas fa-folder">
                                                </i>
                                            </a>

                                            <div class="mx-1"></div>

                                            <a class="btn btn-info btn-sm btn-square"
                                                href="/sukarelawans/{{ $sukarelawan->slug }}/edit">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>

                                            <form id="deleteForm" action="/sukarelawans/{{ $sukarelawan->slug }}"
                                                method="post">
                                                @method('delete')
                                                @csrf
                                            </form>

                                            <div class="mx-1"></div>

                                            <button class="btn btn-danger btn-sm btn-square"
                                                onclick="showDeletionConfirmation()">
                                                <i class="fas fa-trash">
                                                </i>
                                            </button>
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
