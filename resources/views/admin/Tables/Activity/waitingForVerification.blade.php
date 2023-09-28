@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card card-primary card-outline card-outline-tabs">
                <!-- Tabbar -->
                @include('admin.partials.tabbar.activityVerification')
                <!-- /.tabbar -->

                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Titik Kumpul</th>
                                <th>Jumlah Sukarelawan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Penentuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</a></td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $activity->cleanUpDate)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('H:i:s', $activity->startTime)->format('H:i') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('H:i:s', $activity->endTime)->format('H:i') }}
                                    </td>
                                    <td>{{ $activity->gatheringPointUrl }}</td>
                                    <td>{{ $activity->minimumNumOfSukarelawan }} orang</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="form-inline">
                                            <form id="verifyForm" action="/verify/activities/{{ $activity->slug }}"
                                                method="post">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="experiencePointGiven" id="experiencePointGiven">
                                            </form>

                                            <button class="btn btn-success btn-sm btn-square"
                                                onclick="showExperiencePointGivenInput()">
                                                <i class="fas fa-check"></i>
                                            </button>

                                            <form id="rejectForm" action="/reject/activities/{{ $activity->slug }}"
                                                method="post">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="reasonForRejection" id="reasonForRejection">
                                            </form>

                                            <div class="mx-1"></div>

                                            <button class="btn btn-danger btn-sm btn-square"
                                                onclick="showReasonForRejectionInput()">
                                                <i class="fas fa-times"></i>
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
