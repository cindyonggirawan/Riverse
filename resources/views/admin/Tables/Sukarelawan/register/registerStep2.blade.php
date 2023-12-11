@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register-sukarelawan.css') }}" />
@endsection

@php
    $hasNewImage = false;
@endphp

@section('content')
    <div style="height: 1140px;"></div>
    <div class="row">
        <!-- Form -->
        <form action="{{ route('sukarelawan.store', ['step' => 2]) }}" method="post" class="register-container"
            id="register-container-2" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hasNewImage" value="{{ $hasNewImage }}">
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <!-- Card Body -->
            <div class="register-content" id="register-content-2">
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
                    <div class="tab-selected">
                        <a href="/register/sukarelawan" class="tab-link">Sukarelawan</a>
                    </div>
                    <div class="tab-unselected">
                        <a href="/register/fasilitator" class="tab-link">Fasilitator</a>
                    </div>
                </nav>
                <div class="form-steps">
                    <a href="/register/sukarelawan">
                        <div class="circle">
                            1
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 2 ? 'filled' : '' }}">
                        2
                    </div>
                    <div class="line {{ $currentStep - 1 >= 2 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                        3
                    </div>
                </div>
                <div class="form-header">
                    Data Sukarelawan
                </div>
                <div class="form-text">
                    <label for="name" class="required">Nama Lengkap</label>
                    <div class="row">
                        <input type="text" name="name" id="name"
                            class="input-text-long @error('name') is-invalid @enderror" placeholder="Nama Lengkap" required
                            value="{{ Session::get('step2Data.name') ?? old('name') }}">
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-text-division">
                        <label for="gender" class="required">Jenis Kelamin</label>
                        <div class="row">
                            <select name="gender" id="gender"
                                class="input-text-long @error('gender') is-invalid @enderror" required>
                                @if (Session::get('step2Data.gender') ?? old('gender') == 'Perempuan')
                                    <option value="Laki-laki">
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" selected>
                                        Perempuan
                                    </option>
                                @else
                                    <option value="Laki-laki" selected>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan">
                                        Perempuan
                                    </option>
                                @endif
                            </select>
                        </div>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text-division">
                        <label for="dateOfBirth" class="required">Tanggal Lahir</label>
                        <div class="row">
                            <input type="date" name="dateOfBirth" id="dateOfBirth"
                                class="input-text-long @error('dateOfBirth') is-invalid @enderror" placeholder="DD/MM/YYYY"
                                required value="{{ Session::get('step2Data.dateOfBirth') ?? old('dateOfBirth') }}">
                        </div>
                        @error('dateOfBirth')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-text">
                    <label for="nationalIdentityNumber" class="required">Nomor Induk Kependudukan (NIK)</label>
                    <div class="row">
                        <input type="text" name="nationalIdentityNumber" id="nationalIdentityNumber"
                            class="input-text-long @error('nationalIdentityNumber') is-invalid @enderror"
                            placeholder="16 Digit" required
                            value="{{ Session::get('step2Data.nationalIdentityNumber') ?? old('nationalIdentityNumber') }}">
                    </div>
                    @error('nationalIdentityNumber')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="" class="form-image-label required">Kartu Tanda Penduduk (KTP)</label>
                    <div class="row">
                        <div class="custom-file-input">
                            @if (Session::has('step2Data.nationalIdentityCardImageUrl'))
                                <input type="text" name="oldNationalIdentityCardImageUrl"
                                    value="{{ Session::get('step2Data.nationalIdentityCardImageUrl') }}" hidden>
                            @endif

                            <input type="file" class="@error('nationalIdentityCardImageUrl') is-invalid @enderror"
                                name="nationalIdentityCardImageUrl" id="imageInput" accept="image/*"
                                value="{{ Session::get('step2Data.nationalIdentityCardImageUrl') ?? '' }}" hidden />
                            <label for="imageInput">
                                <div class="drop-zone">
                                    <div class="image-preview" id="imagePreview"
                                        @if (Session::has('step2Data.nationalIdentityCardImageUrl')) @else hidden @endif>
                                        @if (Session::has('step2Data.nationalIdentityCardImageUrl'))
                                            <img id="previewImage"
                                                src="{{ asset('storage/images/' . Session::get('step2Data.nationalIdentityCardImageUrl')) ?? '' }}"
                                                alt="Image Preview" />
                                        @else
                                            <img id="previewImage" src="" alt="Image Preview" />
                                        @endif
                                    </div>
                                    @if (Session::has('step2Data.nationalIdentityCardImageUrl'))
                                    @else
                                        <div class="browse-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                viewBox="0 0 50 50" fill="none">
                                                <path d="M25.0001 10.417V39.5837M10.4167 25.0003H39.5834" stroke="#838181"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            Gambar
                                        </div>
                                    @endif
                                </div>
                            </label>
                            @error('nationalIdentityCardImageUrl')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Lanjut</button>
                    <a href="/register/sukarelawan">
                        Sebelumnya
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="register-image" style="background-image: url('{{ asset('/images/Register/register-sk.png') }}');">
        </div>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
