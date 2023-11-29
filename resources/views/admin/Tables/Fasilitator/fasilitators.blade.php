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
                                <th>Logo Image</th>
                                <th>Name</th>
                                <th>Verification Status</th>
                                <th>Fasilitator Type</th>
                                <th>Description</th>
                                <th>Logo Image Url</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Updated At</th>
                                <th><span class="pe-5">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitators as $fasilitator)
                                <tr>
                                    <td>{{ $fasilitator->id }}</a></td>
                                    <td>
                                        @if ($fasilitator->logoImageUrl !== null)
                                            <img src="{{ asset('storage/' . $fasilitator->logoImageUrl) }}"
                                                alt="{{ $fasilitator->user->name }}" class="img-fluid img-square-small">
                                        @else
                                            <img src="{{ asset('images/Fasilitator/logoImages/default.png') }}"
                                                alt="{{ $fasilitator->user->name }}" class="img-fluid img-square-small">
                                        @endif
                                    </td>
                                    <td>{{ $fasilitator->user->name }}</td>
                                    <td>{{ $fasilitator->verificationStatus->name }}</td>
                                    <td>{{ $fasilitator->fasilitatorType->name }}</td>
                                    <td>{{ Str::words($fasilitator->description, 5) }}</td>
                                    <td>{{ $fasilitator->logoImageUrl !== null ? $fasilitator->logoImageUrl : '-' }}</td>
                                    <td>{{ Str::words($fasilitator->address, 5) }}</td>
                                    <td>{{ $fasilitator->phoneNumber }}
                                    </td>
                                    <td>{{ $fasilitator->updated_at }}</td>
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
