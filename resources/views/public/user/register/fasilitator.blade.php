@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection

@php
    $currImageName = 'register-fs.png';
    // $regisSteps = [1, 2, 3];
    $currentRegisStep = 1;
@endphp

@section('content')
    <div class="register-row">
        <div class="register-col">
            <h1>Daftar sebagai <div class="selected">Fasilitator</div>
            </h1>
            <div class="login-row">
                <div class="disabled">
                    Sudah punya akun?
                </div>
                <a href="/login">Masuk</a>
            </div>

            <form action="{{ url('/register/fasilitator') }}" method="post" class="regis-form" enctype="multipart/form-data">
                @csrf
                <h2>Data Akun</h2>
                <div class="form-input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="" value = "{{ old('email') ?? '' }}">
                    @error('email')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="" value = "{{ old('password') ?? '' }}"
                        placeholder="Harus memiliki min. 1 huruf kapital dan angka">
                </div>
                <div class="form-input">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="" value = "">
                    @error('password')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <h2>Data Fasilitator</h2>
                <div class="form-input">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="" value = "">
                </div>
                <div class="form-input">
                    <label for="description">Deskripsi</label>
                    <input type="text" name="description" id="" value = "{{ old('description') ?? '' }}"
                        placeholder="Maksimal 100 huruf">
                    @error('description')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row-fs">
                    <div class="form-input half">
                        <label for="fasilitatorTypeId">Tipe</label>
                        <select id="fasilitatorTypeIds" name="fasilitatorTypeId" class="select-full">
                            <option value="">Pilih Tipe</option>

                            @foreach ($fasilitatorTypes as $fType)
                                <option value="{{ $fType->id }}"
                                    {{ old('fasilitatorTypeId') == $fType->id ? 'selected' : '' }}>
                                    {{ $fType->name }}</option>
                            @endforeach
                        </select>
                        @error('fasilitatorTypeId')
                            <div class="danger caption">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-input half">
                        <label for="logoImageUrl">Logo</label>
                        <div class="profpic-input">
                            <div class="custom-file-input">
                                <input type="file" name="logoImageUrl" id="imageInput" accept="image/*" value=""
                                    hidden />
                                <label for="imageInput">
                                    <div class="drop-zone">
                                        <div class="image-preview" id="imagePreview" hidden>
                                            <img id="previewImage" src="" alt="Image Preview" />
                                        </div>
                                        <div class="browse-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                viewBox="0 0 50 50" fill="none">
                                                <path d="M25.0001 10.417V39.5837M10.4167 25.0003H39.5834" stroke="#838181"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            Gambar
                                        </div>
                                    </div>
                                </label>
                                @error('logoImageUrl')
                                    <span class="danger caption">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Kontak Fasilitator</h2>
                <div class="form-input">
                    <label for="address">Alamat</label>
                    <input type="text" name="address" id="" value = "{{ old('address') ?? '' }}">
                    @error('address')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-input">
                    <label for="phoneNumber">Nomor Telepon</label>
                    <input type="text" name="phoneNumber" id="" value = "{{ old('phoneNumber') ?? '' }}"
                        placeholder="812345678910">
                    @error('phoneNumber')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <button class="btn-fill full" type="submit">
                    Daftar
                </button>
            </form>
        </div>

        <div class="regis-right-img">
            <img src="{{ asset('images/Register/' . $currImageName) }}" alt="">
        </div>
    </div>

    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
