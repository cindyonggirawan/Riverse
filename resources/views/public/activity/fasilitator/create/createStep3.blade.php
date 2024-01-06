@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@php
    // parse sukarelawan kriteria
    $sukarelawanCriteria = explode('; ', Session::get('step2Data.sukarelawanCriteria'));
    // parse sukarelawan equipment
    $sukarelawanEquipment = explode('; ', Session::get('step2Data.sukarelawanEquipment'));
@endphp

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas</h1>
            <div class="form-steps">
                <a href="/activities/create/1">
                    <div class="circle">
                        1
                    </div>
                </a>
                <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                <a href="/activities/create/2">
                    <div class="circle">
                        2
                    </div>
                </a>
                <div class="line {{ $currentStep - 1 >= 2 ? 'filled' : '' }}"></div>
                <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                    3
                </div>
            </div>
        </div>

        <form action="{{ route('activity.publicStore', ['step' => 3]) }}" method="post">
            @csrf
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
                            {{ Session::get('step1Data.name') }}
                        </div>
                        <div class="form-subheadline">
                            Deskripsi Aktivitas
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.description') }}
                        </div>

                        <div class="form-subheadline">
                            Batas Registrasi
                        </div>
                        <div class="form-content">
                            @php
                                $date = Session::get('step1Data.registrationDeadlineDate');
                                $formattedDate = date('d/m/Y', strtotime($date));
                            @endphp
                            {{ $formattedDate }}
                        </div>
                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Pelaksanaan Aktivitas
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-subheadline">
                                    Tanggal Pelaksanaan
                                </div>
                                <div class="form-content">
                                    @php
                                        $date = Session::get('step1Data.cleanUpDate');
                                        $formattedDate = date('d/m/Y', strtotime($date));
                                    @endphp
                                    {{ $formattedDate }}
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-subheadline">
                                    Waktu
                                </div>
                                <div class="form-content">
                                    @php
                                        $startTime = Session::get('step1Data.startTime');
                                        $endTime = Session::get('step1Data.endTime');
                                        $formattedStartTime = date('H:i', strtotime($startTime));
                                        $formattedEndTime = date('H:i', strtotime($endTime));
                                    @endphp
                                    {{ $formattedStartTime }} - {{ $formattedEndTime }} WIB
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Lokasi Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Titik Kumpul
                        </div>
                        <div class="form-content">
                            <a target="_blank" href=" {{ Session::get('step1Data.gatheringPointUrl') }}">
                                {{ Session::get('step1Data.gatheringPointUrl') }}
                            </a>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Banner Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Banner
                        </div>
                        <div class="form-content">
                            <div class="step3-image-preview">
                                @if (Session::has('step1Data.picture'))
                                    <div class="image-preview" id="imagePreview">
                                        <img id="previewImage"
                                            src="{{ asset('storage/images/' . Session::get('step1Data.picture')) ?? '' }}"
                                            alt="Image Preview" />
                                    </div>
                                @else
                                    Tidak ada banner
                                @endif
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Data Sukarelawan
                        </div>
                        <div class="form-subheadline">
                            Nama Pekerjaan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanJobName') }}
                        </div>
                        <div class="form-subheadline">
                            Tugas Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanJobDetail') }}
                        </div>
                        <div class="form-subheadline">
                            Kriteria Sukarelawan
                        </div>
                        <div class="form-content">
                            <div class="perlengkapan-container">
                                @foreach ($sukarelawanCriteria as $criteria)
                                    <div class="perlengkapan">
                                        {{ $criteria }}
                                    </div>
                                @endforeach
                            </div>
                            {{-- {{ Session::get('step2Data.sukarelawanCriteria') }} --}}
                        </div>
                        <div class="form-subheadline">
                            Jumlah Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.minimumNumOfSukarelawan') }} orang
                        </div>
                        <div class="form-subheadline">
                            Perlengkapan Sukarelawan
                        </div>
                        <div class="form-content">
                            <div class="perlengkapan-container">
                                @foreach ($sukarelawanEquipment as $equipment)
                                    <div class="perlengkapan">
                                        {{ $equipment }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Alat Komunikasi
                        </div>
                        <div class="form-subheadline">
                            Group Chat
                        </div>
                        <div class="form-content">
                            <a target="_blank" href="{{ Session::get('step2Data.groupChatUrl') }}">
                                {{ Session::get('step2Data.groupChatUrl') }}
                            </a>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn-fill" id="submitButton">
                        Kirim
                    </button>
                </div>
            </div>
        </form>

        <div class="goBack">
            <a href="/activities/create/2">
                <button>Sebelumnya</button>
            </a>
        </div>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
