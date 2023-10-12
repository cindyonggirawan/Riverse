@extends('layout.index')

@php
    $currentStep = 1;
@endphp

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Buat Aktivitas</h1>
            <div class="form-steps">
                <div class="circle filled">
                    1
                </div>
                <div class="line">
                </div>
                <div class="circle">
                    2
                </div>
                <div class="line">
                </div>
                <div class="circle">
                    3
                </div>
            </div>
        </div>

        <form action="" class="create-activity-form">
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
                            <input type="date" name="" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Waktu Mulai</label>
                            <input type="time" name="" id="">
                        </div>
                        <div class="line">

                        </div>
                        <div class="form-group">
                            <label for="">Waktu Selesai</label>
                            <input type="time" name="" id="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card-container">
                <div class="form-card">
                    <div class="form-header">
                        Lokasi Aktivitaas
                    </div>
                    <label for="">Titik Kumpul</label>
                    <input type="text" name="" id="" placeholder="Tautan Google Map">
                </div>
            </div>

            {{-- FIXME: --}}
            <div class="form-card-container">
                <div class="form-card">
                    <div class="form-header">
                        Banner Aktivitas
                    </div>
                    <label for="">Banner</label>
                    <input type="file" src="" alt="" accept="image/*">
                </div>
            </div>

        </form>
    </div>
@endsection
