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
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Nomor Induk Kependudukan</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Penolakan</th>
                                <th>Alasan Penolakan</th>
                                <th>Penentuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sukarelawans as $sukarelawan)
                                <tr>
                                    <td>{{ $sukarelawan->id }}</a></td>
                                    <td>{{ $sukarelawan->user->name }}</td>
                                    <td>{{ $sukarelawan->gender }}</td>
                                    <td>{{ Carbon\Carbon::parse($sukarelawan->dateOfBirth)->age }} tahun</td>
                                    <td>{{ $sukarelawan->nationalIdentityNumber }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sukarelawan->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sukarelawan->rejected_at)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $sukarelawan->reasonForRejection }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <form id="unrejectForm" action="/unreject/sukarelawans/{{ $sukarelawan->slug }}"
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
