@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity without-steps">
        <div class="top">
            <h1>Edit Profil Sukarelawan</h1>
        </div>

        <form action="{{ route('sukarelawan.update', ['sukarelawan' => $sukarelawan->slug]) }}" method="POST"
            action="patchlink" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="form-step-container">
                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Data Akun
                        </div>
                        <div class="form-text last">
                            <label for="email" class="required">Email</label>
                            <div class="row">
                                <input type="email" name="email" id="email"
                                    class="input-text-long @error('email') is-invalid @enderror"
                                    placeholder="hello@riverse.com" required
                                    value="{{ old('email') ?? $sukarelawan->user->email }}">
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Data Sukarelawan
                        </div>
                        <div class="form-text">
                            <label for="name" class="required">Nama Lengkap</label>
                            <div class="row">
                                <input type="text" name="name" id="name"
                                    class="input-text-long @error('name') is-invalid @enderror" placeholder="Nama Lengkap"
                                    required value="{{ old('name') ?? $sukarelawan->user->name }}">
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
                                        @if (old('gender') ?? $sukarelawan->gender == 'Perempuan')
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
                                        class="input-text-long @error('dateOfBirth') is-invalid @enderror"
                                        placeholder="DD/MM/YYYY" required
                                        value="{{ old('dateOfBirth') ?? $sukarelawan->dateOfBirth }}">
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
                                    placeholder="16 Digit" disabled
                                    value="{{ old('nationalIdentityNumber') ?? $sukarelawan->nationalIdentityNumber }}">
                            </div>
                            @error('nationalIdentityNumber')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-text-division last">
                                <label for="nationalIdentityNumber" class="required">Kartu Tanda Penduduk (KTP)</label>
                                <div class="row disabled">
                                    <img src="{{ asset(
                                        $sukarelawan->nationalIdentityCardImageUrl
                                            ? 'storage/images/' . $sukarelawan->nationalIdentityCardImageUrl
                                            : '/images/' . Config::get('constants.default_card_image'),
                                    ) }}"
                                        alt="Card Image Preview" />
                                </div>
                            </div>
                            <div class="form-text-division last">
                                <label for="" class="form-image-label">Profil</label>
                                <div class="row">
                                    <div class="custom-file-input">
                                        @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                            <input type="text" name="oldPicture"
                                                value="{{ $sukarelawan->profileImageUrl }}" hidden>
                                        @endif

                                        <input type="file" class="@error('picture') is-invalid @enderror" name="picture"
                                            id="imageInput" accept="image/*"
                                            value="{{ $sukarelawan->profileImageUrl ?? '' }}" hidden />
                                        <label for="imageInput">
                                            <div class="drop-zone">
                                                <div class="image-preview" id="imagePreview"
                                                    @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '') @else hidden @endif>
                                                    @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                                        <img id="previewImage"
                                                            src="{{ asset('storage/images/' . $sukarelawan->profileImageUrl) ?? '' }}"
                                                            alt="Image Preview" />
                                                    @else
                                                        <img id="previewImage" src="" alt="Image Preview" />
                                                    @endif
                                                </div>
                                                @if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl !== '')
                                                @else
                                                    <div class="browse-button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="50"
                                                            height="50" viewBox="0 0 50 50" fill="none">
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
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn-fill" id="nextStepButton" name="nextStepButton">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
