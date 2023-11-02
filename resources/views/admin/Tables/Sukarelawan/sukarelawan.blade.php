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
                        <dd class="col-sm-8">{{ $sukarelawan->id }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->user->email }}</dd>

                        <dt class="col-sm-4">Profile Image</dt>
                        <dd class="col-sm-8">
                            @if ($sukarelawan->profileImageUrl !== null)
                                <img src="{{ asset('storage/' . $sukarelawan->profileImageUrl) }}"
                                    alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-big">
                            @else
                                <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                    alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-big">
                            @endif
                        </dd>

                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->user->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Verification Status Id</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->verificationStatusId }}</dd>

                        <dt class="col-sm-4">Verification Status</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->verificationStatus->name }}</dd>

                        <dt class="col-sm-4">Level Id</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->levelId }}</dd>

                        <dt class="col-sm-4">Level</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->level->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Gender</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->gender }}</dd>

                        <dt class="col-sm-4">Date Of Birth</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->dateOfBirth }}</dd>

                        <dt class="col-sm-4">Card Image</dt>
                        <dd class="col-sm-8">
                            @if ($sukarelawan->nationalIdentityCardImageUrl !== null)
                                <img src="{{ asset('storage/' . $sukarelawan->nationalIdentityCardImageUrl) }}"
                                    alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-big">
                            @else
                                <img src="{{ asset('images/Sukarelawan/nationalIdentityCardImages/default.png') }}"
                                    alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-big">
                            @endif
                        </dd>

                        <dt class="col-sm-4">National Identity Number</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->nationalIdentityNumber }}</dd>

                        <dt class="col-sm-4">National Identity Card Image Url</dt>
                        <dd class="col-sm-8">
                            {{ $sukarelawan->nationalIdentityCardImageUrl !== null ? $sukarelawan->nationalIdentityCardImageUrl : '-' }}
                        </dd>

                        <dt class="col-sm-4">Profile Image Url</dt>
                        <dd class="col-sm-8">
                            {{ $sukarelawan->profileImageUrl !== null ? $sukarelawan->profileImageUrl : '-' }}</dd>

                        <dt class="col-sm-4">Experience Point</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->experiencePoint }}</dd>

                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->slug }}</dd>

                        <dt class="col-sm-4">Verified At</dt>
                        <dd class="col-sm-8">
                            {{ $sukarelawan->verified_at !== null ? $sukarelawan->verified_at : '-' }}</dd>

                        <dt class="col-sm-4">Rejected At</dt>
                        <dd class="col-sm-8">
                            {{ $sukarelawan->rejected_at !== null ? $sukarelawan->rejected_at : '-' }}</dd>

                        <dt class="col-sm-4">Reason For Rejection</dt>
                        <dd class="col-sm-8">
                            {{ $sukarelawan->reasonForRejection !== null ? $sukarelawan->reasonForRejection : '-' }}</dd>

                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->created_at }}</dd>

                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $sukarelawan->updated_at }}</dd>
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
