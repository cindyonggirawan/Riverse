@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity without-steps">
        <div class="top">
            <h1>Edit Profil Fasilitator</h1>
        </div>

        <form action="{{ route('fasilitator.update', ['fasilitator' => $fasilitator->slug]) }}" method="POST"
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
                                    value="{{ old('email') ?? $fasilitator->user->email }}">
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
                            Data Fasilitator
                        </div>
                        <div class="form-text">
                            <label for="name" class="required">Nama Lengkap</label>
                            <div class="row">
                                <input type="text" name="name" id="name"
                                    class="input-text-long @error('name') is-invalid @enderror" placeholder="Nama Lengkap"
                                    required value="{{ old('name') ?? $fasilitator->user->name }}">
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
                                        @if (old('fasilitatorTypeId') ?? $fasilitator->fasilitatorType->id == $fasilitatorType->id)
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
                                    placeholder="Minimal 100 karakter" rows="3" style="resize: none;" required>{{ old('description') ?? $fasilitator->description }}</textarea>
                            </div>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text last">
                            <label for="" class="form-image-label required">Logo</label>
                            <div class="row">
                                <div class="custom-file-input">
                                    @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '')
                                        <input type="text" name="oldPicture" value="{{ $fasilitator->logoImageUrl }}"
                                            hidden>
                                    @endif

                                    <input type="file" class="@error('picture') is-invalid @enderror" name="picture"
                                        id="imageInput" accept="image/*" value="{{ $fasilitator->logoImageUrl ?? '' }}"
                                        hidden />
                                    <label for="imageInput">
                                        <div class="drop-zone">
                                            <div class="image-preview" id="imagePreview"
                                                @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '') @else hidden @endif>
                                                @if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl !== '')
                                                    <img id="previewImage"
                                                        src="{{ asset('storage/images/' . $fasilitator->logoImageUrl) ?? '' }}"
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
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Kontak Fasilitator
                        </div>
                        <div class="form-text">
                            <label for="address" class="required">Alamat</label>
                            <div class="row">
                                <textarea name="address" id="address" class="input-text-long @error('address') is-invalid @enderror"
                                    placeholder="Minimal 10 karakter" rows="3" style="resize: none;" required>{{ old('address') ?? $fasilitator->address }}</textarea>
                            </div>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text last">
                            <label for="phoneNumber" class="required">Nomor Telepon</label>
                            <div class="row">
                                <input type="text" name="phoneNumber" id="phoneNumber"
                                    class="input-text-long @error('phoneNumber') is-invalid @enderror"
                                    placeholder="62 123 - 4567 - 89012" required
                                    value="{{ old('phoneNumber') ?? $fasilitator->phoneNumber }}">
                            </div>
                            @error('phoneNumber')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
