@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/sukarelawan.css') }}" />
@endsection



{{-- <img src="{{ asset('images/Levels/' . $imageLevelName . '.png') }}" alt="Level Badge"> --}}

@php

    $clockedInActivityCount = 0;
    $terdaftarActivityCount = 0;
    $claimedActivityCount = 0;

    $points = 0;
    $nextLevel = null;
    $sActivityDetail = $sukarelawan->sukarelawan_activity_details;
    if ($sActivityDetail) {
        for ($i = 0; $i < $sActivityDetail->count(); $i++) {
            if ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'Claimed') {
                $activityPoint = $sActivityDetail[$i]->activity->experiencePointGiven;
                $points += $activityPoint;
                $claimedActivityCount++;
            } elseif ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'ClockedIn') {
                $clockedInActivityCount++;
            } else {
                $terdaftarActivityCount++;
            }
        }
    }

@endphp


@section('content')
    <h1 class="mt-3">Sukarelawan</h1>
    <div class="sukarelawan-row">
        <div class="sukarelawan-col">
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content">
                    <div class="profpic">
                        <img @if (empty($sukarelawan->profileImageUrl)) src={{ asset('images/Sukarelawan/profileImages/default.png') }}
                        @else

                        src={{ asset('storage/' . $sukarelawan->profileImageUrl) }} @endif
                            alt="sukarelawan image">
                    </div>
                    <div class="profile-col">
                        <h1>{{ $sukarelawan->user->name }}</h1>
                        <div class="row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M20 4H4C2.89543 4 2 4.89543 2 6V18C2 19.1046 2.89543 20 4 20H20C21.1046 20 22 19.1046 22 18V6C22 4.89543 21.1046 4 20 4Z"
                                    stroke="#838181" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M22 7L13.03 12.7C12.7213 12.8934 12.3643 12.996 12 12.996C11.6357 12.996 11.2787 12.8934 10.97 12.7L2 7"
                                    stroke="#838181" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>{{ $sukarelawan->user->email }}</p>
                        </div>
                        <div class="row">
                            <a href="">
                                <div class="outline-btn blue">
                                    Ganti Password
                                </div>
                            </a>

                            <form action="/logout" method="post">
                                @csrf
                                <button class="outline-btn red">
                                    Logout
                                </button>
                            </form>


                        </div>
                    </div>
                    <a href="{{ $sukarelawan->slug }}/edit">
                        <div class="edit-profile-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M21.4549 5.41632C21.5499 5.56052 21.5922 5.7331 21.5747 5.9049C21.5573 6.07671 21.481 6.23721 21.3589 6.35932L12.1659 15.5513C12.0718 15.6453 11.9545 15.7126 11.8259 15.7463L7.99689 16.7463C7.87032 16.7793 7.73732 16.7787 7.61109 16.7444C7.48485 16.7101 7.36978 16.6434 7.27729 16.5509C7.18479 16.4584 7.1181 16.3434 7.08382 16.2171C7.04955 16.0909 7.04888 15.9579 7.08189 15.8313L8.08189 12.0033C8.11109 11.8884 8.16616 11.7817 8.24289 11.6913L17.4699 2.47032C17.6105 2.32987 17.8011 2.25098 17.9999 2.25098C18.1986 2.25098 18.3893 2.32987 18.5299 2.47032L21.3589 5.29832C21.3948 5.33432 21.4269 5.37386 21.4549 5.41632ZM19.7679 5.82832L17.9999 4.06132L9.48189 12.5793L8.85689 14.9723L11.2499 14.3473L19.7679 5.82832Z"
                                    fill="white" />
                                <path
                                    d="M19.6406 17.1599C19.9139 14.8238 20.0012 12.4698 19.9016 10.1199C19.8994 10.0645 19.9087 10.0093 19.9288 9.95769C19.9489 9.90608 19.9795 9.85916 20.0186 9.81989L21.0026 8.83589C21.0295 8.80885 21.0636 8.79014 21.1008 8.78203C21.1381 8.77392 21.1769 8.77674 21.2126 8.79015C21.2483 8.80356 21.2794 8.827 21.3021 8.85764C21.3248 8.88828 21.3381 8.92483 21.3406 8.96289C21.5258 11.7541 21.4555 14.5564 21.1306 17.3349C20.8946 19.3569 19.2706 20.9419 17.2576 21.1669C13.7629 21.5539 10.2362 21.5539 6.74157 21.1669C4.72957 20.9419 3.10457 19.3569 2.86857 17.3349C2.45397 13.7903 2.45397 10.2095 2.86857 6.66489C3.10457 4.64289 4.72857 3.05789 6.74157 2.83289C9.39394 2.53877 12.0663 2.46752 14.7306 2.61989C14.7687 2.62262 14.8052 2.63623 14.8359 2.6591C14.8665 2.68196 14.8899 2.71313 14.9034 2.74891C14.9169 2.78468 14.9198 2.82357 14.9119 2.86096C14.9039 2.89835 14.8854 2.93268 14.8586 2.95989L13.8656 3.95189C13.8267 3.99064 13.7803 4.02101 13.7292 4.04113C13.6781 4.06125 13.6234 4.0707 13.5686 4.06889C11.3453 3.99331 9.11952 4.07853 6.90857 4.32389C6.26251 4.39539 5.65942 4.68261 5.19672 5.13914C4.73403 5.59567 4.43874 6.19485 4.35857 6.83989C3.95762 10.2682 3.95762 13.7316 4.35857 17.1599C4.43874 17.8049 4.73403 18.4041 5.19672 18.8606C5.65942 19.3172 6.26251 19.6044 6.90857 19.6759C10.2636 20.0509 13.7356 20.0509 17.0916 19.6759C17.7376 19.6044 18.3407 19.3172 18.8034 18.8606C19.2661 18.4041 19.5604 17.8049 19.6406 17.1599Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content status-aktivitas">
                    <div class="row fs">
                        <div class="col fs">
                            <h3>Identitas</h3>
                            <div class="row">
                                <div class="col-sm">
                                    <p class="disabled">
                                        NIK
                                    </p>
                                    <p>
                                        {{ $sukarelawan->nationalIdentityNumber }}
                                    </p>
                                </div>
                                <div class="col-sm">
                                    <p class="disabled">
                                        Tanggal Lahir
                                    </p>
                                    <p>
                                        {{ $sukarelawan->dateOfBirth }}
                                    </p>
                                </div>
                            </div>
                            <div class="col fs">
                                <div class="disabled">
                                    Foto Kartu Tanda Pengenal (KTP)
                                </div>
                                <div class="ktp-container">
                                    @if ($sukarelawan->nationalIdentityCardImageUrl == null || $sukarelawan->nationalIdentityCardImageUrl->isEmpty())
                                        <img src={{ asset('images/Sukarelawan/nationalIdentityCardImages/default.png') }}
                                            alt="">
                                    @else
                                        <img src={{ asset('storage/' . $sukarelawan->nationalIdentityCardImageUrl) }}
                                            alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <img class="ktp-illustration"
                            src={{ asset('images/Sukarelawan/nationalIdentityCardImages/identitas-illustration.png') }}
                            alt="">
                    </div>
                </div>

            </div>
        </div>
        <div class="sukarelawan-col">
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content col">
                    <div class="levels-row">
                        @php
                            $currLevelIndex = 0;
                            $nextLevelMinPoint = 0;
                        @endphp
                        @foreach ($levels as $level)
                            @php
                                $imageLevelName = strtolower(str_replace(' ', '_', $level->name));
                                $comparisonResult = strcmp(preg_replace('/\D/', '', $sukarelawan->level->name), preg_replace('/\D/', '', $level->name));
                            @endphp

                            @if ($comparisonResult < 0)
                                <div class="level-img-container disabled ">
                                    <img src="{{ asset('images/Levels/' . $imageLevelName . '.png') }}" alt="Level Badge">
                                </div>
                            @else
                                @php
                                    $nextLevelMinPoint += $level->maximumExperiencePoint;
                                @endphp
                                @if ($sukarelawan->level->name == $level->name)
                                    <div class="level-img-container  current">
                                        <img src="{{ asset('images/Levels/' . $imageLevelName . '.png') }}"
                                            alt="Level Badge">
                                    </div>
                                @else
                                    <div class="level-img-container">
                                        <img src="{{ asset('images/Levels/' . $imageLevelName . '.png') }}"
                                            alt="Level Badge">
                                    </div>
                                @endif
                            @endif
                            @php
                                $currLevelIndex++;
                            @endphp
                        @endforeach
                    </div>
                    <h1>{{ $sukarelawan->level->name }}</h1>
                    <div class="level-progress-container">
                        <div class="progress-bar">
                            @php
                                $levelProgressPercentage = ceil($points / $nextLevelMinPoint) * 10;
                            @endphp
                            <div class="progress-fill" style="width: {{ $levelProgressPercentage }}%">
                            </div>
                        </div>
                        <div class="spaced-row">
                            <p class="selected">{{ $points . ' XP' }}</p>
                            <p>{{ $nextLevelMinPoint }}</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content col status-aktivitas">
                    <h3>Status Aktivitas</h3>
                    <div class="row">
                        <div class="col fs">
                            {{-- get aktivitas status Claimed --}}
                            <h2 class="hijau">{{ $claimedActivityCount }} aktivitas</h2>
                            <p>XP sudah dicairkan</p>
                        </div>
                        <div class="col fs">
                            {{-- get aktivitas status ClockedIn --}}
                            <h2 class="biru">{{ $clockedInActivityCount }} aktivitas</h2>
                            <p>menunggu pencairan XP</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col fs">
                            {{-- get aktivitas status Terdaftar --}}
                            <h2 class="kuning">{{ $terdaftarActivityCount }} aktivitas</h2>
                            <p>yang sedang diikuti</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-3">Aktivitas yang diminati</h3>
    <div class="sukarelawan-activities-row">
        @if ($sActivityDetail != null && $sActivityDetail->count() > 0)
            @foreach ($sActivityDetail as $sad)
                <x-activity-card :activity="$sad->activity" />
            @endforeach
        @endif
    </div>
@endsection
