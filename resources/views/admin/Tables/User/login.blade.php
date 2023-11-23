@extends('layout.index')

@section('css')
{{-- @include('layout.useBootstrap') --}}
<link rel="stylesheet" href="{{ asset('/css/login.css') }}"/>
@endsection

@section('content')
<div class="row">
    <div>
        <!-- Form -->
        <form action="/login" method="post" class="login-container">
            @csrf
            <!-- Card Body -->
            <div class="login-content">
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
                <div class="form-text-header">
                    <h1>Masuk</h1>
                    <div class="register-account-text">
                        <p>Belum punya akun?</p>
                        <a href="/register">Daftar</a>
                    </div>
                </div>
                <div class="form-text">
                    <label for="email" class="required">Email</label>
                    <div class="row">
                        <input type="email" name="email" id="email"
                            class="input-text-long @error('email') is-invalid @enderror" placeholder="Email" required
                            autofocus value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="password" class="required">Password</label>
                    <div class="row">
                        <input type="password" name="password" id="password"
                            class="input-text-long @error('password') is-invalid @enderror" placeholder="Password"
                            required>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <a class="forgot-password-text" href="/forgot-password">Lupa password?</a>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Login</button>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
    </div>
    <div class="login-image" style="background-image: url('{{ asset('/images/login-image.png') }}');">

    </div>
</div>
@endsection
