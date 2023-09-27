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
                        <dd class="col-sm-8">{{ $activity->id }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Verification Status Id</dt>
                        <dd class="col-sm-8">{{ $activity->verificationStatusId }}</dd>

                        <dt class="col-sm-4">Verification Status</dt>
                        <dd class="col-sm-8">{{ $activity->verificationStatus->name }}</dd>

                        <dt class="col-sm-4">River Id</dt>
                        <dd class="col-sm-8">{{ $activity->riverId }}</dd>

                        <dt class="col-sm-4">River</dt>
                        <dd class="col-sm-8">{{ $activity->river->name }}</dd>

                        <dt class="col-sm-4">Fasilitator Id</dt>
                        <dd class="col-sm-8">{{ $activity->fasilitatorId }}</dd>

                        <dt class="col-sm-4">Fasilitator</dt>
                        <dd class="col-sm-8">{{ $activity->fasilitator->user->name }}</dd>

                        <dt class="col-sm-4">Activity Status Id</dt>
                        <dd class="col-sm-8">{{ $activity->activityStatusId }}</dd>

                        <dt class="col-sm-4">Activity Status</dt>
                        <dd class="col-sm-8">{{ $activity->activityStatus->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $activity->name }}</dd>

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $activity->description }}</dd>

                        <dt class="col-sm-4">Registration Deadline Date</dt>
                        <dd class="col-sm-8">{{ $activity->registrationDeadlineDate }}</dd>

                        <dt class="col-sm-4">Clean Up Date</dt>
                        <dd class="col-sm-8">{{ $activity->cleanUpDate }}</dd>

                        <dt class="col-sm-4">Start Time</dt>
                        <dd class="col-sm-8">{{ $activity->startTime }}</dd>

                        <dt class="col-sm-4">End Time</dt>
                        <dd class="col-sm-8">{{ $activity->endTime }}</dd>

                        <dt class="col-sm-4">Gathering Point Url</dt>
                        <dd class="col-sm-8">{{ $activity->gatheringPointUrl }}</dd>

                        <dt class="col-sm-4">Banner Image Url</dt>
                        <dd class="col-sm-8">{{ $activity->bannerImageUrl !== null ? $activity->bannerImageUrl : '-' }}
                        </dd>

                        <dt class="col-sm-4">Sukarelawan Job Name</dt>
                        <dd class="col-sm-8">{{ $activity->sukarelawanJobName }}</dd>

                        <dt class="col-sm-4">Sukarelawan Job Detail</dt>
                        <dd class="col-sm-8">{{ $activity->sukarelawanJobDetail }}</dd>

                        <dt class="col-sm-4">Sukarelawan Criteria</dt>
                        <dd class="col-sm-8">{{ $activity->sukarelawanCriteria }}</dd>

                        <dt class="col-sm-4">Minimum Number Of Sukarelawan</dt>
                        <dd class="col-sm-8">{{ $activity->minimumNumOfSukarelawan }}</dd>

                        <dt class="col-sm-4">Sukarelawan Equipment</dt>
                        <dd class="col-sm-8">{{ $activity->sukarelawanEquipment }}</dd>

                        <dt class="col-sm-4">Group Chat Url</dt>
                        <dd class="col-sm-8">{{ $activity->groupChatUrl }}</dd>

                        <dt class="col-sm-4">Experience Point Given</dt>
                        <dd class="col-sm-8">{{ $activity->experiencePointGiven }}</dd>

                        <dt class="col-sm-4">QR Code Image Url</dt>
                        <dd class="col-sm-8">{{ $activity->qrCodeImageUrl !== null ? $activity->qrCodeImageUrl : '-' }}
                        </dd>

                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $activity->slug }}</dd>

                        <dt class="col-sm-4">Verified At</dt>
                        <dd class="col-sm-8">
                            {{ $activity->verified_at !== null ? $activity->verified_at : '-' }}</dd>

                        <dt class="col-sm-4">Rejected At</dt>
                        <dd class="col-sm-8">
                            {{ $activity->rejected_at !== null ? $activity->rejected_at : '-' }}</dd>

                        <dt class="col-sm-4">Reason For Rejection</dt>
                        <dd class="col-sm-8">
                            {{ $activity->reasonForRejection !== null ? $activity->reasonForRejection : '-' }}</dd>

                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $activity->created_at }}</dd>

                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $activity->updated_at }}</dd>
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
