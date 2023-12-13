@extends('layout.index')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/forgot-password.css') }}"/>
@endsection

@section('content')
<div class="forgot-password-body">
    <div class="forgot-password-container">
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            @if ($errors->any())
                <div class="alert error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            @if (session()->has('status'))
                <div class="alert success">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Card Body -->
            <div class="card-center">
                <div class="form-text">
                    <h1>Lupa Password</h5>
                    <h5>Masukkan email yang Anda gunakan untuk masuk</h2>
                </div>
                <div class="form-text">
                    <label for="email" class="required"><h4>Email</h4></label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email"
                            class="input-text-long  @error('email') is-invalid @enderror" placeholder="hello@riverse.com" required
                            autofocus value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="purple-outline-btn-long">Kirim</button>
            </div>
        </form>
    </div>

    <div class="forgot-password-image" style="background-image: url('{{ asset('/images/Authentication/forgot-password/image_6-removebg-preview 1.png') }}');">

    </div>
</div>
@endsection
