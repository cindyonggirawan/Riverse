@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection

@php
    $currImageName = 'register-done.png';
    // $regisSteps = [1, 2, 3];
    $currentRegisStep = 1;
@endphp

@section('content')
    <div class="register-row">
        <div class="register-col">
            <h1>Daftar sebagai <div class="selected">Sukarelawan</div>
            </h1>
            <div class="login-row">
                <div class="disabled">
                    Sudah punya akun?
                </div>
                <a href="/login">Masuk</a>
            </div>

            {{-- <div class="step-row">
                <div class="line"></div>
                @foreach ($regisSteps as $rs)
                    @if ($currentRegisStep == $rs)
                        <div class="step-circle filled">
                            {{ $rs }}
                        </div>
                    @else
                        <div class="step-circle">
                            {{ $rs }}
                        </div>
                    @endif
                @endforeach
            </div> --}}

            <form action="{{ url('/register/sukarelawan') }}" method="post" class="regis-form" enctype="multipart/form-data">
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

                <h2>Data Sukarelawan</h2>
                <div class="form-input">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="" value = "">
                </div>
                <div class="row">
                    <div class="form-input half">
                        <label for="gender">Jenis Kelamin</label>
                        <select id="genders" name="gender">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                        </select>
                        @error('gender')
                            <div class="danger caption">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-input half">
                        <label for="dateOfBirth">Tanggal Lahir</label>
                        <input type="date" name="dateOfBirth" id="" value = "{{ old('dateOfBirth') ?? '' }}">
                        @error('dateOfBirth')
                            <div class="danger caption">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-input">
                    <label for="nationalIdentityNumber">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" name="nationalIdentityNumber" id=""
                        value = "{{ old('nationalIdentityNumber') }}">
                    @error('nationalIdentityNumber')
                        <div class="danger caption">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-input">
                    <label for="ktp">Kartu Tanda Penduduk (KTP)</label>
                    <div class="caption">
                        *Bagi calon sukarelawan yang berusia dibawah 17 tahun,
                        silahkan memasukkan gambar kartu pelajar
                    </div>

                    <div class="custom-file-input">
                        <input type="file" name="nationalIdentityCardImageUrl" id="imageInput" accept="image/*"
                            value="" hidden />
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
                        @error('nationalIdentityCardImageUrl')
                            <span class="danger caption">{{ $message }}</span>
                        @enderror
                    </div>
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
