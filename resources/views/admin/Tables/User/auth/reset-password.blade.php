@extends('layout.index')

@section('css')
{{-- @include('layout.useBootstrap') --}}
<link rel="stylesheet" href="{{ asset('/css/reset-password.css') }}"/>
@endsection

@section('content')
<div class="row">
    <div>
        <!-- Form -->
        <form action="{{ route('password.update') }}" method="post" class="reset-password-container">
            @csrf
            <!-- Card Body -->
            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            <div class="reset-password-content">
                <div class="form-text">
                    <h1>Lupa Password</h5>
                    <h5>Masukkan password baru Anda</h2>
                </div>
                <div class="form-text">
                    <label for="password" class="required"><h4>Password Baru</h4></label>
                    <div class="row">
                        <input type="password" name="password" id="password"
                            class="input-text-long @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter"
                            required>
                        <div class="input-group-append">
                            <button id="toggle_password" class="btn btn-default" type="button">
                                <i id="password_eye_icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="password_confirmation" class="required"><h4>Konfirmasi Password Baru</h4></label>
                    <div class="row">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="input-text-long @error('password_confirmation') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required>
                        <div class="input-group-append">
                            <button id="toggle_password_confirmation" class="btn btn-default" type="button">
                                <i id="password_confirmation_eye_icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Simpan</button>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
    </div>
    <div class="reset-password-image" style="background-image: url('{{ asset('/images/Authentication/reset-password/image_7-removebg-preview1.png') }}');">

    </div>
</div>
@endsection
