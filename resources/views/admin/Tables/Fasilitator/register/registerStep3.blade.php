@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register-fasilitator.css') }}" />
@endsection

@section('content')
    <div style="height: 840px;"></div>
    <div class="row">
        <!-- Form -->
        <form action="{{ route('fasilitator.store', ['step' => 3]) }}" method="post" class="register-container"
            id="register-container-3" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <!-- Card Body -->
            <div class="register-content" id="register-content-3">
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
                    <a href="/register/fasilitator">
                        <div class="circle">
                            1
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                    <a href="/register/fasilitator/2">
                        <div class="circle">
                            2
                        </div>
                    </a>
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
                    Kontak Fasilitator
                </div>
                <div class="form-text">
                    <label for="address" class="required">Alamat</label>
                    <div class="row">
                        <textarea name="address" id="address" class="input-text-long @error('address') is-invalid @enderror"
                            placeholder="Minimal 10 karakter" rows="3" style="resize: none;" required>{{ Session::get('step3Data.address') ?? old('address') }}</textarea>
                    </div>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="phoneNumber" class="required">Nomor Telepon</label>
                    <div class="row">
                        <input type="text" name="phoneNumber" id="phoneNumber"
                            class="input-text-long @error('phoneNumber') is-invalid @enderror"
                            placeholder="62 123 - 4567 - 89012" required
                            value="{{ Session::get('step3Data.phoneNumber') ?? old('phoneNumber') }}">
                    </div>
                    @error('phoneNumber')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Lanjut</button>
                    <a href="/register/fasilitator/2">
                        Sebelumnya
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="register-image" style="background-image: url('{{ asset('/images/Register/register-fs.png') }}');">
        </div>
    </div>
@endsection
