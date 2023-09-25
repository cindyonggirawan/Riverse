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
                        <dd class="col-sm-8">{{ $fasilitator->id }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $fasilitator->user->email }}</dd>

                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $fasilitator->user->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Verification Status Id</dt>
                        <dd class="col-sm-8">{{ $fasilitator->verificationStatusId }}</dd>

                        <dt class="col-sm-4">Verification Status</dt>
                        <dd class="col-sm-8">{{ $fasilitator->verificationStatus->name }}</dd>

                        <dt class="col-sm-4">Fasilitator Type Id</dt>
                        <dd class="col-sm-8">{{ $fasilitator->fasilitatorTypeId }}</dd>

                        <dt class="col-sm-4">Fasilitator Type</dt>
                        <dd class="col-sm-8">{{ $fasilitator->fasilitatorType->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $fasilitator->description }}</dd>

                        <dt class="col-sm-4">Logo Image Url</dt>
                        <dd class="col-sm-8">{{ $fasilitator->logoImageUrl !== null ? $fasilitator->logoImageUrl : '-' }}
                        </dd>

                        <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8">{{ $fasilitator->address }}</dd>

                        <dt class="col-sm-4">Phone Number</dt>
                        <dd class="col-sm-8">{{ $fasilitator->phoneNumber }}</dd>

                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $fasilitator->slug }}</dd>

                        <dt class="col-sm-4">Verified At</dt>
                        <dd class="col-sm-8">
                            {{ $fasilitator->verified_at !== null ? $fasilitator->verified_at : '-' }}</dd>

                        <dt class="col-sm-4">Rejected At</dt>
                        <dd class="col-sm-8">
                            {{ $fasilitator->rejected_at !== null ? $fasilitator->rejected_at : '-' }}</dd>

                        <dt class="col-sm-4">Reason For Rejection</dt>
                        <dd class="col-sm-8">
                            {{ $fasilitator->reasonForRejection !== null ? $fasilitator->reasonForRejection : '-' }}</dd>

                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $fasilitator->created_at }}</dd>

                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $fasilitator->updated_at }}</dd>
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
