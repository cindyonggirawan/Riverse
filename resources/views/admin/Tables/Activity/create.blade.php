@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/activities/create" method="post" class="form-horizontal">
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label required">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" required
                                    value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">
                            <i class="fas fa-angle-left">
                            </i>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection