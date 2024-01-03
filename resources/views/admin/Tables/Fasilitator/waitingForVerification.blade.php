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
                                <th>Penentuan</th>
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
                                    <td>
                                        <div class="form-inline">
                                            <form id="verifyForm" action="/verify/fasilitators/{{ $fasilitator->slug }}"
                                                method="post">
                                                @method('patch')
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm btn-square">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form id="rejectForm{{ $fasilitator->id }}"
                                                action="/reject/fasilitators/{{ $fasilitator->slug }}" method="post">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="reasonForRejection"
                                                    id="reasonForRejection{{ $fasilitator->id }}">
                                            </form>

                                            <div class="mx-1"></div>

                                            <button class="btn btn-danger btn-sm btn-square"
                                                onclick="showReasonForRejectionInput('{{ $fasilitator->id }}')">
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
