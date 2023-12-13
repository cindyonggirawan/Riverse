@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card card-primary card-outline card-outline-tabs">
                <!-- Tabbar -->
                @include('admin.partials.tabbar.sukarelawanVerification')
                <!-- /.tabbar -->

                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Gambar Profil</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>XP</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Gambar Kartu</th>
                                <th>Nomor Induk Kependudukan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Verifikasi</th>
                                <th>Tanggal Penolakan</th>
                                <th>Alasan Penolakan</th>
                                <th>Status</th>
                                {{-- <th>Pengaturan</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sukarelawans as $sukarelawan)
                                <tr>
                                    <td>{{ $sukarelawan->id }}</a></td>
                                    <td>
                                        @if ($sukarelawan->profileImageUrl !== null)
                                            <img src="{{ asset('storage/images/' . $sukarelawan->profileImageUrl) }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $sukarelawan->user->name }}</td>
                                    <td>{{ $sukarelawan->level->name }}</td>
                                    <td>{{ $sukarelawan->experiencePoint }} XP</td>
                                    <td>{{ $sukarelawan->gender }}</td>
                                    <td>{{ Carbon\Carbon::parse($sukarelawan->dateOfBirth)->age }} tahun</td>
                                    <td>
                                        @if ($sukarelawan->nationalIdentityCardImageUrl !== null)
                                            <img src="{{ asset('storage/images/' . $sukarelawan->nationalIdentityCardImageUrl) }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Sukarelawan/nationalIdentityCardImages/default.png') }}"
                                                alt="{{ $sukarelawan->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
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
                                    {{-- <td>
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
                                    </td> --}}
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
