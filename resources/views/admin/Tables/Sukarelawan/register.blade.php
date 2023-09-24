@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/register/sukarelawan" method="post" class="form-horizontal">
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label required">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email" required
                                    value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label required">Password</label>
                            <div class="input-group col-sm-8">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                <div class="input-group-append">
                                    <button id="toggle_password" class="btn btn-default" type="button">
                                        <i id="password_eye_icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-4 col-form-label required">Password
                                Confirmation</label>
                            <div class="input-group col-sm-8">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Password Confirmation" required>
                                <div class="input-group-append">
                                    <button id="toggle_password_confirmation" class="btn btn-default" type="button">
                                        <i id="password_confirmation_eye_icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

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

                        <div class="form-group row">
                            <label for="gender" class="col-sm-4 col-form-label required">Gender</label>
                            <div class="col-sm-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" id="male" value="Male"
                                        class="custom-control-input @error('gender') is-invalid @enderror" required
                                        {{ old('gender') === 'Male' ? 'checked' : '' }}>
                                    <label for="male" class="custom-control-label">Male</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" id="female" value="Female"
                                        class="custom-control-input @error('gender') is-invalid @enderror" required
                                        {{ old('gender') === 'Female' ? 'checked' : '' }}>
                                    <label for="female" class="custom-control-label">Female</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="dateOfBirth" class="col-sm-4 col-form-label required">Date Of Birth</label>
                            <div class="input-group col-sm-8 date" id="dob" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#dob" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="dateOfBirth" id="dateOfBirth"
                                    class="form-control datetimepicker-input @error('dateOfBirth') is-invalid @enderror"
                                    data-target="#dob" placeholder="DD/MM/YYYY" required value="{{ old('dateOfBirth') }}">
                            </div>
                            @error('dateOfBirth')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="nationalIdentityNumber" class="col-sm-4 col-form-label required">National Identity
                                Number</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                                <input type="text" name="nationalIdentityNumber" id="nationalIdentityNumber"
                                    class="form-control @error('nationalIdentityNumber') is-invalid @enderror"
                                    placeholder="National Identity Number" required
                                    value="{{ old('nationalIdentityNumber') }}">
                            </div>
                            @error('nationalIdentityNumber')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="text-center"><a href="/login">I already have an account</a></div>
                    </div>
                    <!-- /.card-body -->
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">
                            <i class="fas fa-angle-left">
                            </i>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Register</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection
