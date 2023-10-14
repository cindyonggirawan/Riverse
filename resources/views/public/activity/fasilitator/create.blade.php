@extends('layout.index')

@php
    $currentStep = 3;
@endphp

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

        <form action="" class="create-activity-form" enctype="multipart/form-data">
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">

            @if ($currentStep == 1)
                <div class="form-step-container">
                    <div class="form-card-container">
                        <div class="form-card">
                            <div class="form-header">
                                Data Aktivitas
                            </div>
                            <label for="name">Judul Lengkap</label>
                            <input type="text" name="name" id="name" placeholder="Maksimal 50 Karakter">
                            <label for="description">Deskripsi Aktivitas</label>
                            <input type="text" name="description" id="description"
                                placeholder="Jelaskan pentingnya tindakan dan tujuannya">
                            <label for="registrationDeadlineDate">Batas Registrasi</label>
                            <input type="date" name="registrationDeadlineDate" id="registrationDeadlineDate">
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
                                    <input type="date" name="cleanUpDate" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Waktu Mulai</label>
                                    <input type="time" name="startTime" id="">
                                </div>
                                <div class="line">

                                </div>
                                <div class="form-group">
                                    <label for="">Waktu Selesai</label>
                                    <input type="time" name="endTime" id="">
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
                            <input type="text" name="gatheringPointUrl" id="" placeholder="Tautan Google Map">
                        </div>
                    </div>

                    <div class="form-card-container">
                        <div class="form-card">
                            <div class="form-header">
                                Banner Aktivitas
                            </div>
                            <label for="">Banner</label>


                            <div class="custom-file-input">
                                <input type="file" id="imageInput" accept="image/*" hidden />
                                <label for="imageInput">
                                    <div class="drop-zone">
                                        <div class="image-preview" id="imagePreview" hidden>
                                            <img id="previewImage" src="#" alt="Image Preview" />
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
                            </div>
                        </div>
                    </div>

                    <div class="btn-fill" id="nextStepButton">
                        Lanjut
                    </div>
                </div>
            @endif

            @if ($currentStep == 2)
                <div class="form-step-container">
                    <div class="form-card-container">
                        <div class="form-card">
                            <div class="form-header">
                                Data Sukarelawan
                            </div>
                            <label for="">Nama Pekerjaan</label>
                            <input type="text" name="sukarelawanJobName" id="sukarelawanJobName"
                                placeholder="Maksimal 50 Karakter">

                            <label for="">Tugas Sukarelawan</label>
                            <textarea class="lg" name="sukarelawanJobDetail" id="sukarelawanJobDetail" placeholder="Jelaskan tugas relawan"></textarea>

                            <label for="">Kriteria Sukarelawan</label>
                            <textarea class="lg" name="sukarelawanCriteria" id="sukarelawanCriteria" placeholder="Batasi dengan ';'"
                                rows="4"></textarea>

                            <label for="sukarelawan">Jumlah Sukarelawan</label>
                            <div class="number-input">
                                <button type="button" onclick="decrementValue()" class="decrement">-</button>
                                <input type="number" name="minimumNumberOfSukarelawan" id="minimumNumberOfSukarelawan"
                                    value="0" min="0" />
                                <button type="button" onclick="incrementValue()" class="increment">+</button>
                            </div>

                            <label for="">Perlengkapan Sukarelawan</label>
                            <textarea class="lg" name="sukarelawanEquipment" id="sukarelawanEquipment" placeholder="Batasi dengan ';'"
                                rows="4"></textarea>
                        </div>
                    </div>

                    <div class="form-card-container">
                        <div class="form-card">
                            <div class="form-header">
                                Alat
                            </div>
                            <label for="name">Group Chat</label>
                            <input type="text" name="groupChatUrl" id="groupChatUrl"
                                placeholder="Tautan Whatsapp/Line">
                        </div>
                    </div>

                    <div class="btn-fill" id="nextStepButton">
                        Lanjut
                    </div>
                </div>
            @endif

            @if ($currentStep == 3)
                <div class="form-recap">
                    <div class="form-card-container">
                        <div class="form-card">

                            <div class="form-header">
                                Pratinjau Data Aktivitas
                            </div>
                            <div class="form-subheadline">
                                Judul Lengkap
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>
                            <div class="form-subheadline">
                                Deskripsi Aktivitas
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                            <div class="form-subheadline">
                                Batas Registrasi
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>


                            <div class="divider"></div>
                            <div class="form-header">
                                Pratinjau Pelaksanaan Aktivitas
                            </div>
                            <div class="form-subheadline">
                                Tanggal Pelaksanaan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                            <div class="divider"></div>
                            <div class="form-header">
                                Pratinjau Lokasi Aktivitas
                            </div>
                            <div class="form-subheadline">
                                Titik Kumpul
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                            <div class="divider"></div>
                            <div class="form-header">
                                Pratinjau Banner Aktivitas
                            </div>
                            <div class="form-subheadline">
                                Banner
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                            <div class="divider"></div>
                            <div class="form-header">
                                Pratinjau Data Sukarelawan
                            </div>
                            <div class="form-subheadline">
                                Nama Pekerjaan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>
                            <div class="form-subheadline">
                                Tugas Sukarelawan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>
                            <div class="form-subheadline">
                                Kriteria Sukarelawan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>
                            <div class="form-subheadline">
                                Jumlah Sukarelawan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>
                            <div class="form-subheadline">
                                Perlengkapan Suakrelawan
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                            <div class="divider"></div>
                            <div class="form-header">
                                Pratinjau Alat Komunikasi
                            </div>
                            <div class="form-subheadline">
                                Group Chat
                            </div>
                            <div class="form-content">
                                {{ 'TEXT DISINI' }}
                            </div>

                        </div>
                    </div>

                    <div class="btn-fill submit" id="submitButton">
                        Submit
                    </div>
                </div>
            @endif




        </form>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
