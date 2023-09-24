@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <!-- /.Card Body-->
                <div class="card-body table-responsive">
                    <table id="table1" class="table table-bordered table-hover table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Maximum Experience Point</th>
                                <th>Medal Image Url</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $level)
                                <tr>
                                    <td>{{ $level->id }}</a></td>
                                    <td>{{ $level->name }}</td>
                                    <td>{{ $level->maximumExperiencePoint }}</td>
                                    <td>{{ $level->medalImageUrl !== null ? $level->medalImageUrl : '-' }}</td>
                                    <td>{{ $level->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/levels/{{ $level->slug }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
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
