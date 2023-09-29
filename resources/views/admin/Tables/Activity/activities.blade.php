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
                                <th>Verification Status</th>
                                <th>River</th>
                                <th>Fasilitator</th>
                                <th>Activity Status</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Registration Deadline Date</th>
                                <th>Clean Up Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Gathering Point Url</th>
                                <th>Banner Image Url</th>
                                <th>Sukarelawan Job Name</th>
                                <th>Sukarelawan Job Detail</th>
                                <th>Sukarelawan Criteria</th>
                                <th>Minimum Number Of Sukarelawan</th>
                                <th>Sukarelawan Equipment</th>
                                <th>Group Chat Url</th>
                                <th>Group Chat QR Code Image Url</th>
                                <th>Experience Point Given</th>
                                <th>Attendance QR Code Image Url</th>
                                <th>Updated At</th>
                                <th><span class="pe-5">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->verificationStatus->name }}</td>
                                    <td>{{ $activity->river->name }}</td>
                                    <td>{{ $activity->fasilitator->user->name }}</td>
                                    <td>{{ $activity->activityStatus->name }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ Str::words(strip_tags($activity->description), 5) }}</td>
                                    <td>{{ $activity->registrationDeadlineDate }}</td>
                                    <td>{{ $activity->cleanUpDate }}</td>
                                    <td>{{ $activity->startTime }}</td>
                                    <td>{{ $activity->endTime }}</td>
                                    <td>{{ $activity->gatheringPointUrl }}</td>
                                    <td>{{ $activity->bannerImageUrl !== null ? $activity->bannerImageUrl : '-' }}</td>
                                    <td>{{ $activity->sukarelawanJobName }}</td>
                                    <td>{{ Str::words(strip_tags($activity->sukarelawanJobDetail), 5) }}</td>
                                    <td>{{ Str::words(strip_tags($activity->sukarelawanCriteria), 5) }}</td>
                                    <td>{{ $activity->minimumNumOfSukarelawan }}</td>
                                    <td>{{ Str::words(strip_tags($activity->sukarelawanEquipment), 5) }}</td>
                                    <td>{{ $activity->groupChatUrl }}</td>
                                    <td>{{ $activity->groupChatQRCodeImageUrl !== null ? $activity->groupChatQRCodeImageUrl : '-' }}
                                    <td>{{ $activity->experiencePointGiven }}</td>
                                    <td>{{ $activity->attendanceQRCodeImageUrl !== null ? $activity->attendanceQRCodeImageUrl : '-' }}
                                    </td>
                                    <td>{{ $activity->updated_at }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-primary btn-sm btn-square"
                                                href="/activities/{{ $activity->slug }}">
                                                <i class="fas fa-folder">
                                                </i>
                                            </a>

                                            <div class="mx-1"></div>

                                            <a class="btn btn-info btn-sm btn-square"
                                                href="/activities/{{ $activity->slug }}/edit">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>

                                            <form id="deleteForm" action="/activities/{{ $activity->slug }}"
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
