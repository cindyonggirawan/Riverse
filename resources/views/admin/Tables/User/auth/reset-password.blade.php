@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('password.update') }}" method="post" class="form-horizontal">
                    @csrf
                    <!-- Card Body -->
                    <input type="hidden" name="token" value="{{ request()->token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label required">New Password</label>
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
                    <!-- /.card-body -->
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">
                            <i class="fas fa-angle-left">
                            </i>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Update Password</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection
