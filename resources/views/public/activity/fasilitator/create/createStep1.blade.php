@extends('layout.index')


@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@php
    $hasNewImage = false;
@endphp


@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas</h1>
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
            </div>
        </div>

        <form action="{{ route('activity.publicStore', ['step' => 1]) }}" method="post" class="create-activity-form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hasNewImage" value="{{ $hasNewImage }}">

            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <div class="form-step-container">
                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Data Aktivitas
                        </div>
                        <div class="form-text">
                            <label for="name" class="required">Judul Lengkap</label>
                            <div class="row">
                                <input type="text" name="name" id="name"
                                    class="input-text-long @error('name') is-invalid @enderror"
                                    placeholder="Maksimal 50 Karakter" required
                                    value="{{ Session::get('step1Data.name') ?? old('name') }}">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-text">
                            <label for="description" class="required">Deskripsi Aktivitas</label>
                            <div class="row">
                                <textarea name="description" id="description" class="input-text-long @error('description') is-invalid @enderror"
                                    placeholder="Jelaskan pentingnya tindakan dan tujuannya" rows="3" style="resize: none;" required>{{ Session::get('step1Data.description') ?? old('description') }}</textarea>
                            </div>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-text-division last">
                                <label for="registrationDeadlineDate" class="required">Batas Registrasi</label>
                                <div class="row">
                                    <input type="date" name="registrationDeadlineDate" id="registrationDeadlineDate"
                                        class="input-text-long @error('registrationDeadlineDate') is-invalid @enderror"
                                        placeholder="DD/MM/YYYY" required
                                        value="{{ Session::get('step1Data.registrationDeadlineDate') ?? old('registrationDeadlineDate') }}">
                                </div>
                                @error('registrationDeadlineDate')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Pelaksanaan Aktivitas
                        </div>
                        <div class="row">
                            <div class="form-text-division last">
                                <label for="cleanUpDate" class="required">Tanggal Pelaksanaan</label>
                                <div class="row">
                                    <input type="date" name="cleanUpDate" id="cleanUpDate"
                                        class="input-text-long @error('cleanUpDate') is-invalid @enderror"
                                        placeholder="DD/MM/YYYY" required
                                        value="{{ Session::get('step1Data.cleanUpDate') ?? old('cleanUpDate') }}">
                                </div>
                                @error('cleanUpDate')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row-division">
                                <div class="form-text-division last">
                                    <label for="startTime" class="required">Waktu Mulai</label>
                                    <div class="row">
                                        <input type="time" name="startTime" id="startTime"
                                            class="input-text-long @error('startTime') is-invalid @enderror"
                                            placeholder="HH:MM" required
                                            value="{{ Session::get('step1Data.startTime') ?? old('startTime') }}">
                                    </div>
                                    @error('startTime')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="line"></div>
                                <div class="form-text-division last">
                                    <label for="endTime" class="required">Waktu Selesai</label>
                                    <div class="row">
                                        <input type="time" name="endTime" id="endTime"
                                            class="input-text-long @error('endTime') is-invalid @enderror"
                                            placeholder="HH:MM" required
                                            value="{{ Session::get('step1Data.endTime') ?? old('endTime') }}">
                                    </div>
                                    @error('endTime')
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
                            Lokasi Aktivitas
                        </div>
                        <div class="form-text last">
                            <label for="gatheringPointUrl" class="required">Titik Kumpul</label>
                            <div class="row">
                                <input type="text" name="gatheringPointUrl" id="gatheringPointUrl"
                                    class="input-text-long @error('gatheringPointUrl') is-invalid @enderror"
                                    placeholder="Tautan Google Map" required
                                    value="{{ Session::get('step1Data.gatheringPointUrl') ?? old('gatheringPointUrl') }}">
                            </div>
                            @error('gatheringPointUrl')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Banner Aktivitas
                        </div>
                        <div class="form-text last">
                            <label for="" class="form-image-label">Banner</label>
                            <div class="row">
                                <div class="custom-file-input">
                                    @if (Session::has('step1Data.picture'))
                                        <input type="text" name="oldPicture"
                                            value="{{ Session::get('step1Data.picture') }}" hidden>
                                    @endif

                                    <input type="file" class="@error('picture') is-invalid @enderror" name="picture"
                                        id="imageInput" accept="image/*"
                                        value="{{ Session::get('step1Data.picture') ?? '' }}" hidden />
                                    <label for="imageInput">
                                        <div class="drop-zone">
                                            <div class="image-preview" id="imagePreview"
                                                @if (Session::has('step1Data.picture')) @else hidden @endif>
                                                @if (Session::has('step1Data.picture'))
                                                    <img id="previewImage"
                                                        src="{{ asset('storage/images/' . (Session::get('step1Data.picture') ?? '')) }}"
                                                        alt="Image Preview" />
                                                @else
                                                    <img id="previewImage" src="" alt="Image Preview" />
                                                @endif
                                            </div>
                                            @if (Session::has('step1Data.picture'))
                                            @else
                                                <div class="browse-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                        viewBox="0 0 50 50" fill="none">
                                                        <path d="M25.0001 10.417V39.5837M10.4167 25.0003H39.5834"
                                                            stroke="#9fadc4" stroke-width="2" stroke-linecap="round"
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

                <div class="card-footer">
                    <button type="submit" class="btn-fill" id="nextStepButton" name="nextStepButton">
                        Lanjut
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
