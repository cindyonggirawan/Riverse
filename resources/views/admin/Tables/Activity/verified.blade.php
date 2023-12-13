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
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>XP</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Titik Kumpul</th>
                                <th>Jumlah Sukarelawan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Verifikasi</th>
                                <th>Penentuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</a></td>
                                    <td>
                                        @if ($activity->bannerImageUrl !== null)
                                            <img src="{{ asset('storage/images/' . $activity->bannerImageUrl) }}"
                                                alt="{{ $activity->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Activity/bannerImages/default.png') }}"
                                                alt="{{ $activity->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->experiencePointGiven }} XP</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $activity->cleanUpDate)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('H:i:s', $activity->startTime)->format('H:i') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('H:i:s', $activity->endTime)->format('H:i') }}
                                    </td>
                                    <td>{{ $activity->gatheringPointUrl }}</td>
                                    <td>{{ $activity->minimumNumOfSukarelawan }} orang</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->format('d/m/Y') }}
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->verified_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="form-inline">
                                            <form id="unverifyForm" action="/unverify/activities/{{ $activity->slug }}"
                                                method="post">
                                                @method('patch')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary btn-sm btn-square">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
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
