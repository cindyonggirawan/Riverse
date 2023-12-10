@extends('layout.index')

@section('css')
    {{-- @include('layout.useBootstrap') --}}
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}" />
@endsection

@section('content')
    <div class="hero">
        <h1>
            Bergabung menjadi Sukarelawan dan Fasilitator kebersihan Sungai Ciliwung!
        </h1>
        <div class="row">
            <a href="register/sukarelawan" class="fill-btn-large">
                Ingin Membantu
                {{-- redirect to Register as Sukarelawan --}}
            </a>
            <a href="register/fasilitator" class="outline-btn-large">
                Butuh Bantuan
                {{-- redirect to Register as Fasilitator --}}
            </a>
        </div>
    </div>

    <div class="page-content">
        <h3>
            Tentang Platform
        </h3>
        <div class="about">
            <div class="about-left">
                <div class="about-card" style="background-image: url('{{ asset('/images/about_card_1.png') }}');">
                    <h3 class="selected">{{ $sukarelawanCount }} +</h3>
                    <p>Sukarelawan</p>
                </div>
            </div>
            <div class="about-col">
                <div class="about-card about-card-sm"
                    style="background-image: url('{{ asset('/images/about_card_2.png') }}');">
                    <h3 class="selected">{{ $activitiesCount }} +</h3>
                    <p>Aktvitas</p>
                </div>
                <div class="about-card about-card-sm"
                    style="background-image: url('{{ asset('/images/about_card_3.png') }}');">
                    <h3 class="selected">{{ $fasilitatorCount }} +</h3>
                    <p>Fasilitator</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <h3>Aktvitas yang berada di
            <a href="/" class="selected">Sungai Ciliwung</a>
        </h3>

        <div class="activity-row">

            {{-- TODO: FETCH HOME PAGE ACTIVITIES HERE --}}
            <x-activity-card-big :activity="$activities[0]" />
            <div class="activity-col">
                <x-activity-card-horizontal :activity="$activities[0]" />
                <x-activity-card-horizontal :activity="$activities[1]" />
                <x-activity-card-horizontal :activity="$activities[2]" />
            </div>
        </div>
        <div class="activity-row">
            <x-activity-card :activity="$activities[0]" />
            <x-activity-card :activity="$activities[1]" />
            <x-activity-card :activity="$activities[2]" />

            <div class="lihat-semua-card-container">
                <img src="{{ asset('images/activities_hands.png') }}" alt="">
                <div class="activities-card-content">
                    <h1>{{ $activitiesCount }}+</h1>
                    <p>aktivitas tersedia<br />pada platform ini</p>
                    <a href="/activities" class="purple-outline-btn-long">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
@endsection
