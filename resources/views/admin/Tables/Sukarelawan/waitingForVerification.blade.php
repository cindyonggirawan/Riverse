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
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Gambar Kartu</th>
                                <th>Nomor Induk Kependudukan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Penentuan</th>
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
                                    <td>
                                        <div class="form-inline">
                                            <form id="verifyForm" action="/verify/sukarelawans/{{ $sukarelawan->slug }}"
                                                method="post">
                                                @method('patch')
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm btn-square">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form id="rejectForm{{ $sukarelawan->id }}"
                                                action="/reject/sukarelawans/{{ $sukarelawan->slug }}" method="post">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="reasonForRejection"
                                                    id="reasonForRejection{{ $sukarelawan->id }}">
                                            </form>

                                            <div class="mx-1"></div>

                                            <button class="btn btn-danger btn-sm btn-square"
                                                onclick="showReasonForRejectionInput('{{ $sukarelawan->id }}')">
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
