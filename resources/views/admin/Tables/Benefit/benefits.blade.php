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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Coupon Code</th>
                                <th>Updated At</th>
                                <th>Action</th>
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
                                        <form id="deleteForm" action="/admin/benefits/{{ $benefit->slug }}"
                                            method="post">
                                            @method('delete')
                                            @csrf
                                            <div class="mx-1"></div>
                                            <button class="btn btn-danger btn-sm btn-square">
                                                <i class="fas fa-trash">
                                                </i>
                                            </button>
                                        </form>
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
