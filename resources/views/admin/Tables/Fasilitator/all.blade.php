@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card card-primary card-outline card-outline-tabs">
                <!-- Tabbar -->
                @include('admin.partials.tabbar.fasilitatorVerification')
                <!-- /.tabbar -->

                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Gambar Logo</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Verifikasi</th>
                                <th>Tanggal Penolakan</th>
                                <th>Alasan Penolakan</th>
                                <th>Status</th>
                                <th>Pengaturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitators as $fasilitator)
                                <tr>
                                    <td>{{ $fasilitator->id }}</a></td>
                                    <td>
                                        @if ($fasilitator->logoImageUrl !== null)
                                            <img src="{{ asset('storage/images/' . $fasilitator->logoImageUrl) }}"
                                                alt="{{ $fasilitator->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Fasilitator/logoImages/default.png') }}"
                                                alt="{{ $fasilitator->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $fasilitator->user->name }}</td>
                                    <td>{{ $fasilitator->fasilitatorType->name }}</td>
                                    <td>{{ $fasilitator->address }}</td>
                                    <td>{{ $fasilitator->phoneNumber }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fasilitator->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $fasilitator->verified_at !== null ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fasilitator->verified_at)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $fasilitator->rejected_at !== null ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fasilitator->rejected_at)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $fasilitator->reasonForRejection !== null ? $fasilitator->reasonForRejection : '-' }}
                                    </td>
                                    <td>{{ $fasilitator->verificationStatus->name }}</a></td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="btn btn-primary btn-sm btn-square"
                                                href="/fasilitators/{{ $fasilitator->slug }}">
                                                <i class="fas fa-folder">
                                                </i>
                                            </a>

                                            <div class="mx-1"></div>

                                            <a class="btn btn-info btn-sm btn-square"
                                                href="/fasilitators/{{ $fasilitator->slug }}/edit">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>

                                            <form id="deleteForm" action="/fasilitators/{{ $fasilitator->slug }}"
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
