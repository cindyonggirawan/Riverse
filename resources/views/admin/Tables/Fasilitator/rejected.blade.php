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
                    <table id="table1" class="table table-bordered table-hover table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Penolakan</th>
                                <th>Alasan Penolakan</th>
                                <th>Penentuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitators as $fasilitator)
                                <tr>
                                    <td>{{ $fasilitator->id }}</a></td>
                                    <td>{{ $fasilitator->user->name }}</td>
                                    <td>{{ $fasilitator->fasilitatorType->name }}</td>
                                    <td>{{ $fasilitator->address }}</td>
                                    <td>{{ $fasilitator->phoneNumber }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fasilitator->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fasilitator->rejected_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $fasilitator->reasonForRejection !== null ? $fasilitator->reasonForRejection : '-' }}
                                    </td>
                                    <td>
                                        <div class="form-inline">
                                            <form id="unrejectForm" action="/unreject/fasilitators/{{ $fasilitator->slug }}"
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
