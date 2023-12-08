@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register-fasilitator.css') }}" />
@endsection

@php
    $hasNewImage = false;
@endphp

@section('content')
    <div class="row">
        <!-- Form -->
        <form action="{{ route('fasilitator.store', ['step' => 2]) }}" method="post" class="register-container"
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
                    Data Fasilitator
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
                <div class="form-text">
                    <label for="fasilitatorTypeId" class="required">Tipe</label>
                    <div class="row">
                        <select name="fasilitatorTypeId" id="fasilitatorTypeId"
                            class="input-text-long @error('fasilitatorTypeId') is-invalid @enderror" required>
                            @foreach ($fasilitatorTypes as $fasilitatorType)
                                @if (Session::get('step2Data.fasilitatorTypeId') ?? old('fasilitatorTypeId') == $fasilitatorType->id)
                                    <option value="{{ $fasilitatorType->id }}" selected>
                                        {{ $fasilitatorType->name }}
                                    </option>
                                @else
                                    <option value="{{ $fasilitatorType->id }}">
                                        {{ $fasilitatorType->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('fasilitatorTypeId')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="description" class="required">Deskripsi</label>
                    <div class="row">
                        <textarea name="description" id="description" class="input-text-long @error('description') is-invalid @enderror"
                            placeholder="Minimal 100 karakter" rows="3" style="resize: none;" required>{{ Session::get('step2Data.description') ?? old('description') }}</textarea>
                    </div>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">
                    <label for="" class="form-image-label required">Logo</label>
                    <div class="row">
                        <div class="custom-file-input">
                            @if (Session::has('step2Data.logoImageUrl'))
                                <input type="text" name="oldLogoImageUrl"
                                    value="{{ Session::get('step2Data.logoImageUrl') }}" hidden>
                            @endif

                            <input type="file" class="@error('logoImageUrl') is-invalid @enderror" name="logoImageUrl"
                                id="imageInput" accept="image/*" value="{{ Session::get('step2Data.logoImageUrl') ?? '' }}"
                                hidden />
                            <label for="imageInput">
                                <div class="drop-zone">
                                    <div class="image-preview" id="imagePreview"
                                        @if (Session::has('step2Data.logoImageUrl')) @else hidden @endif>
                                        @if (Session::has('step2Data.logoImageUrl'))
                                            <img id="previewImage"
                                                src="{{ asset('storage/' . Session::get('step2Data.logoImageUrl')) ?? '' }}"
                                                alt="Image Preview" />
                                        @else
                                            <img id="previewImage" src="" alt="Image Preview" />
                                        @endif
                                    </div>
                                    @if (Session::has('step2Data.logoImageUrl'))
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
                            @error('logoImageUrl')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Lanjut</button>
                    <a href="/register/fasilitator">
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
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
