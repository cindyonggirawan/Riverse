@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/sukarelawan.css') }}" />
@endsection


@section('content')
    <form action="{{ route('fasilitator.update', ['fasilitator' => $fasilitator->slug]) }}" method="POST" action="patchlink"
        enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="sukarelawan-form-col">
            <h1 class="mt-3">Edit Profil Fasilitator</h1>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content full">
                    <h3>Data Akun</h3>
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ old('email') ?? $fasilitator->user->email }}">
                    @error('email')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content full">
                    <h3>Data Sukarelawan</h3>
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') ?? $fasilitator->user->name }}">
                    @error('name')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror

                    <div class="row-even">
                        <div class="col">
                            <label for="fasilitatorTypeId">Tipe</label>
                            <select id="fasilitatorTypeIds" name="fasilitatorTypeId" class="select-full">
                                <option value="">Pilih Tipe</option>

                                @foreach ($fasilitatorTypes as $fType)
                                    <option value="{{ $fType->id }}"
                                        {{ old('fasilitatorTypeId') ?? $fasilitator->fasilitatorType->id == $fType->id ? 'selected' : '' }}>
                                        {{ $fType->name }}</option>
                                @endforeach
                            </select>
                            @error('fasilitatorTypeId')
                                <div class="danger caption">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <label for="description">Deskripsi</label>
                    <textarea name="description">{{ old('description') ?? $fasilitator->description }}</textarea>
                    @error('description')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror

                    <div class="row-even">


                        <div class="col">
                            <p>Logo Fasilitator</p>
                            <div class="profpic-input">
                                <div class="custom-file-input">
                                    {{-- Store Session's picture to oldPicture --}}
                                    @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '')
                                        <input type="text" name="oldPicture" value="{{ $fasilitator->logoImageUrl }}"
                                            hidden>
                                    @endif

                                    <input type="file" name="picture" id="imageInput" accept="image/*"
                                        value="{{ $fasilitator->logoImageUrl ?? '' }}" hidden />
                                    <label for="imageInput">
                                        <div class="drop-zone">
                                            <div class="image-preview" id="imagePreview"
                                                @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '') @else hidden @endif>
                                                @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '')
                                                    <img id="previewImage"
                                                        src="{{ asset('storage/images/' . $fasilitator->logoImageUrl) }}"
                                                        alt="Image Preview" />
                                                @else
                                                    <img id="previewImage" src="" alt="Image Preview" />
                                                @endif
                                            </div>
                                            @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '')
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
                                        <p class="merah error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content full">
                    <h3>Kontak Fasilitator</h3>
                    <label for="address">Alamat</label>
                    <textarea name="address">{{ old('address') ?? $fasilitator->address }}</textarea>
                    @error('address')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror
                    <label for="phoneNumber">Nomor Telepon</label>
                    <div class="row">
                        <div class="disabled">
                            +62
                        </div>
                        <input type="text" name="phoneNumber"
                            value="{{ old('phoneNumber') ?? $fasilitator->phoneNumber }}">
                    </div>
                    @error('phoneNumber')
                        <p class="merah error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-fill half">Simpan</button>
        </div>


    </form>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
