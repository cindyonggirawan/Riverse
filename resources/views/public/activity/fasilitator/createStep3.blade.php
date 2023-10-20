@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas - Langkah 3</h1>
            <div class="form-steps">
                <div class="circle">
                    1
                </div>
                <div class="line filled"></div>
                <div class="circle filled">
                    2
                </div>
                <div class="line filled"></div>
                <div class="circle">
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
                            {{ Session::get('step1Data.registrationDeadline') }}
                        </div>


                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Pelaksanaan Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Tanggal Pelaksanaan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.cleanUpDate') }}
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Lokasi Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Titik Kumpul
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.gatheringPointUrl') }}
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Banner Aktivitas
                        </div>
                        <div class="form-subheadline">
                            Banner
                        </div>
                        <div class="form-content">
                            {{ Session::get('step1Data.picture') }}
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
                            {{ Session::get('step2Data.sukarelawanCriteria') }}
                        </div>
                        <div class="form-subheadline">
                            Jumlah Sukarelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.minimumNumOfSukarelawan') }}
                        </div>
                        <div class="form-subheadline">
                            Perlengkapan Suakrelawan
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.sukarelawanEquipment') }}
                        </div>

                        <div class="divider"></div>
                        <div class="form-header">
                            Pratinjau Alat Komunikasi
                        </div>
                        <div class="form-subheadline">
                            Group Chat
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.groupChatUrl') }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="btn-fill submit" id="submitButton">
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>

        <div class="goBack">
            <form action="">
                @csrf
                <button>
                    Sebelumnya
                </button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/dragDropImage.js') }}"></script>
@endsection
