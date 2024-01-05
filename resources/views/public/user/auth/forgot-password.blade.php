@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/forgot-password.css') }}" />
@endsection

@section('content')
    <div class="row">
        <!-- Form -->
        <form action="{{ route('password.email') }}" method="post" class="forgot-password-container">
            @csrf
            <!-- Card Body -->
            <div class="forgot-password-content">
                <div class="form-text-header">
                    <h1>Lupa Password</h1>
                    <div class="forgot-password-text">
                        <p>Masukkan email yang Anda gunakan untuk masuk</p>
                    </div>
                </div>
                <div class="form-text">
                    <label for="email" class="required">Email</label>
                    <div class="row">
                        <input type="email" name="email" id="email"
                            class="input-text-long @error('email') is-invalid @enderror" placeholder="hello@riverse.com"
                            required autofocus value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @if (session()->has('status'))
                        <div class="text-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Kirim</button>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="forgot-password-image"
            style="background-image: url('{{ asset('/images/Authentication/forgot-password/image_6-removebg-preview 1.png') }}'); background-repeat: no-repeat;">
        </div>
    </div>
@endsection
