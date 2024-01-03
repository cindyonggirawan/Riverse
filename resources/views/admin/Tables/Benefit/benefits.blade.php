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
                                <th>Level</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Kode Kupon</th>
                                <th>Tanggal Dibuat</th>
                                <th>Pengaturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($benefits as $benefit)
                                <tr>
                                    <td>{{ $benefit->id }}</a></td>
                                    <td>{{ $benefit->level->name }}</a></td>
                                    <td>{{ $benefit->name }}</td>
                                    <td>{{ Str::words($benefit->description, 5) }}</td>
                                    <td>{{ $benefit->couponCode }}</td>
                                    <td>{{ $benefit->updated_at }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <form id="deleteForm{{ $benefit->id }}"
                                                action="/admin/benefits/{{ $benefit->slug }}" method="post">
                                                @method('delete')
                                                @csrf
                                            </form>

                                            <button class="btn btn-danger btn-sm btn-square"
                                                onclick="showDeletionConfirmation('{{ $benefit->id }}')">
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
