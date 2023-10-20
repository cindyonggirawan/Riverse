@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas</h1>
            <div class="form-steps">
                <div class="circle {{ $currentStep == 1 ? 'filled' : '' }}">
                    1
                </div>
                <div class="line">
                </div>
                <div class="circle {{ $currentStep == 2 ? 'filled' : '' }}">
                    2
                </div>
                <div class="line">
                </div>
                <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                    3
                </div>
            </div>
        </div>

        <form action="{{ route('activity.publicStore', ['step' => 1]) }}" method="post" class="create-activity-form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <div class="form-step-container">
                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Data Aktivitas
                        </div>
                        <label for="name">Judul Lengkap</label>
                        <input type="text" name="name" id="name" placeholder="Maksimal 50 Karakter"
                            value="{{ Session::get('step1Data')['name'] ?? '' }}">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <label for="description">Deskripsi Aktivitas</label>
                        <input type="text" name="description" id="description"
                            placeholder="Jelaskan pentingnya tindakan dan tujuannya"
                            value="{{ Session::get('step1Data')['description'] ?? '' }}">
                        @error('description')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <label for="registrationDeadlineDate">Batas Registrasi</label>
                        <input type="date" name="registrationDeadlineDate" id="registrationDeadlineDate"
                            value="{{ Session::get('step1Data')['registrationDeadlineDate'] ?? '' }}">
                        @error('registrationDeadlineDate')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Pelaksanaan Aktivitas
                        </div>
                        <div class="row">
                            <div class="form-group half">
                                <label for="">Tanggal Pelaksanaan</label>
                                <input type="date" name="cleanUpDate" id=""
                                    value="{{ Session::get('step1Data')['cleanUpDate'] ?? '' }}">
                                @error('cleanUpDate')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Waktu Mulai</label>
                                <input type="time" name="startTime" id=""
                                    value="{{ Session::get('step1Data')['startTime'] ?? '' }}">
                                @error('startTime')
                                    <span class="error">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="line">

                            </div>
                            <div class="form-group">
                                <label for="">Waktu Selesai</label>
                                <input type="time" name="endTime" id=""
                                    value="{{ Session::get('step1Data')['endTime'] ?? '' }}">
                                @error('endTime')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Lokasi Aktivitas
                        </div>
                        <label for="">Titik Kumpul</label>
                        <input type="text" name="gatheringPointUrl" id="" placeholder="Tautan Google Map"
                            value="{{ Session::get('step1Data')['gatheringPointUrl'] ?? '' }}">
                        @error('gahteringPointUrl')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Banner Aktivitas
                        </div>
                        <label for="">Banner</label>


                        <div class="custom-file-input">
                            <input type="file" name="picture" id="imageInput" accept="image/*"
                                value="{{ Session::get('step1Data.picture') ?? '' }}" hidden />
                            <label for="imageInput">
                                <div class="drop-zone">
                                    <div class="image-preview" id="imagePreview"
                                        @if (Session::has('step1Data.picture')) @else hidden @endif>
                                        @if (Session::has('step1Data.picture'))
                                            <img id="previewImage"
                                                src="{{ asset('storage/' . Session::get('step1Data.picture')) ?? '' }}"
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
                                                <path d="M25.0001 10.417V39.5837M10.4167 25.0003H39.5834" stroke="#838181"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

                <button type="submit" class="btn-fill" id="nextStepButton" name="nextStepButton">
                    Lanjut
                </button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
