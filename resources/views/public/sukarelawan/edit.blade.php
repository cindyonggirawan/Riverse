@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/sukarelawan.css') }}" />
@endsection


@section('content')
    <form action="{{ route('sukarelawan.update', ['sukarelawan' => $sukarelawan->slug]) }}" method="POST" action="patchlink"
        enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="sukarelawan-form-col">
            <h1 class="mt-3">Edit Profil Sukarelawan</h1>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content full">
                    <h3>Data Akun</h3>
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ old('email') ?? $sukarelawan->user->email }}">
                    @error('email')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content full">
                    <h3>Data Sukarelawan</h3>
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') ?? $sukarelawan->user->name }}">
                    @error('name')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror

                    <div class="row-even">
                        <div class="col">
                            <label for="gender">Jenis Kelamin</label>
                            <select id="genders" name="gender">
                                <option value="Perempuan"
                                    {{ old('gender') == 'Perempuan' || $sukarelawan->gender == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                                <option value="Laki-laki"
                                    {{ old('gender') == 'Laki-laki' || $sukarelawan->gender == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                            </select>
                            @error('gender')
                                <p class="merah error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="dateOfBirth">Tanggal Lahir</label>
                            <input type="date" name="dateOfBirth"
                                value="{{ old('dateOfBirth') ?? $sukarelawan->dateOfBirth }}">
                            @error('dateOfBirth')
                                <p class="merah error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <label for="nik" class="disabled">Nomor Induk Kependudukan (NIK)</label>
                    {{-- <input type="text" name="nationalIdentityNumber"
                        value="{{ old('nationalIdentityNumber') ?? $sukarelawan->nationalIdentityNumber }}"> --}}
                    <p class="disabled-input">
                        {{ $sukarelawan->nationalIdentityNumber }}
                    </p>
                    {{-- @error('nationalIdentityNumber')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror --}}

                    <div class="row-even">
                        <div class="col">
                            <p class="disabled">Kartu Tanda Penduduk (KTP)</p>
                            <div class="ktp-container disabled">
                                @if ($sukarelawan->nationalIdentityCardImageUrl == null || empty($sukarelawan->nationalIdentityCardImageUrl))
                                    <img src={{ asset('images/Sukarelawan/nationalIdentityCardImages/default.png') }}
                                        alt="">
                                @else
                                    <img src={{ asset('storage/images/' . $sukarelawan->nationalIdentityCardImageUrl) }}
                                        alt="">
                                @endif
                            </div>

                        </div>

                        <div class="col">
                            <p>Gambar Profil</p>
                            <div class="profpic-input">
                                <div class="custom-file-input">
                                    {{-- Store Session's picture to oldPicture --}}
                                    @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                        <input type="text" name="oldPicture" value="{{ $sukarelawan->profileImageUrl }}"
                                            hidden>
                                    @endif

                                    <input type="file" name="picture" id="imageInput" accept="image/*"
                                        value="{{ $sukarelawan->profileImageUrl ?? '' }}" hidden />
                                    <label for="imageInput">
                                        <div class="drop-zone">
                                            <div class="image-preview" id="imagePreview"
                                                @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '') @else hidden @endif>
                                                @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                                    <img id="previewImage"
                                                        src="{{ asset('storage/images/' . $sukarelawan->profileImageUrl) }}"
                                                        alt="Image Preview" />
                                                @else
                                                    <img id="previewImage" src="" alt="Image Preview" />
                                                @endif
                                            </div>
                                            @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                            @else
                                                <div class="browse-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                        viewBox="0 0 50 50" fill="none">
                                                        <path d="M25.0001 10.417V39.5837M10.4167 25.0003H39.5834"
                                                            stroke="#838181" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    Gambar
                                                </div>
                                            @endif

                                        </div>
                                    </label>
                                    @error('picture')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-fill half">Simpan</button>
        </div>


    </form>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
