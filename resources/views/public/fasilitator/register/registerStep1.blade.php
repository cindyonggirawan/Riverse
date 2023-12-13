@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register-fasilitator.css') }}" />
@endsection

@section('content')
    <div style="height: 860px;"></div>
    <div class="row">
        <!-- Form -->
        <form action="{{ route('fasilitator.store', ['step' => 1]) }}" method="post" class="register-container"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <!-- Card Body -->
            <div class="register-content">
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="form-text-header">
                    <h1>Daftar</h1>
                    <div class="register-account-text">
                        <p>Sudah punya akun?</p>
                        <a href="/login">Masuk</a>
                    </div>
                </div>
                <nav class="row tab-menu">
                    <div class="tab-unselected">
                        <a href="/register/sukarelawan" class="tab-link">Sukarelawan</a>
                    </div>
                    <div class="tab-selected">
                        <a href="/register/fasilitator" class="tab-link">Fasilitator</a>
                    </div>
                </nav>
                <div class="form-steps">
                    <div class="circle {{ $currentStep == 1 ? 'filled' : '' }}">
                        1
                    </div>
                    <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 2 ? 'filled' : '' }}">
                        2
                    </div>
                    <div class="line {{ $currentStep - 1 >= 2 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                        3
                    </div>
                    <div class="line {{ $currentStep - 1 >= 3 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 4 ? 'filled' : '' }}">
                        4
                    </div>
                </div>
                <div class="form-header">
                    Data Akun
                </div>
                <div class="form-text">
                    <label for="email" class="required">Email</label>
                    <div class="row">
                        <input type="email" name="email" id="email"
                            class="input-text-long @error('email') is-invalid @enderror" placeholder="hello@riverse.com"
                            required value="{{ Session::get('step1Data.email') ?? old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="password" class="required">Password</label>
                    <div class="row">
                        <input type="password" name="password" id="password"
                            class="input-text-long @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter"
                            required value="{{ Session::get('step1Data.password') ?? '' }}">
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="password_confirmation" class="required">Konfirmasi Password</label>
                    <div class="row">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="input-text-long @error('password_confirmation') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required
                            value="{{ Session::get('step1Data.password') ?? '' }}">
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Lanjut</button>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="register-image" style="background-image: url('{{ asset('/images/Register/register-fs.png') }}');">
        </div>
    </div>
@endsection
