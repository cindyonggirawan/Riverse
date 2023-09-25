@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card card-primary card-outline card-outline-tabs">
                <!-- Tabbar -->
                @include('admin.partials.verificationTabbar')
                <!-- /.tabbar -->

                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>XP</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Nomor Induk Kependudukan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Verifikasi</th>
                                <th>Tanggal Penolakan</th>
                                <th>Alasan Penolakan</th>
                                <th>Status</th>
                                <th>Pengaturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sukarelawans as $sukarelawan)
                                <tr>
                                    <td>{{ $sukarelawan->id }}</a></td>
                                    <td>{{ $sukarelawan->user->name }}</td>
                                    <td>{{ $sukarelawan->level->name }}</td>
                                    <td>{{ $sukarelawan->experiencePoint }} XP</td>
                                    <td>{{ $sukarelawan->gender }}</td>
                                    <td>{{ Carbon\Carbon::parse($sukarelawan->dateOfBirth)->age }} tahun</td>
                                    <td>{{ $sukarelawan->nationalIdentityNumber }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sukarelawan->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $sukarelawan->verified_at !== null ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sukarelawan->verified_at)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->rejected_at !== null ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sukarelawan->rejected_at)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->reasonForRejection !== null ? $sukarelawan->reasonForRejection : '-' }}
                                    </td>
                                    <td>{{ $sukarelawan->verificationStatus->name }}</a></td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-info btn-sm btn-square" href="#">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>

                                            <form id="deleteForm" action="#" method="post">
                                                @method('delete')
                                                @csrf
                                            </form>

                                            <div class="mx-1"></div>

                                            <button type="submit" class="btn btn-danger btn-sm btn-square"
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
