@php
    use Carbon\Carbon;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    $sukarelawanCriteria = explode('; ', $activity->sukarelawanCriteria);
    $sukarelawanEquipment = explode('; ', $activity->sukarelawanEquipment);
@endphp

@php
    // NOTE: Buat checking status Sukarelawan di Aktivitas tertentu
    $isTerdaftar = false;
    $isClockedIn = false;
    $isClaimed = false;
    $isLiked = false;
    
    if (auth()->check() && auth()->user()->sukarelawan) {
        // Check if the user is registered for the activity
    
        $terdaftarStatus = 'Terdaftar';
        $isTerdaftar = $activity->sukarelawan_activity_details
            ->where('sukarelawanActivityStatus.name', $terdaftarStatus)
            ->where('sukarelawanId', auth()->user()->sukarelawan->id)
            ->isNotEmpty();
    
        if ($isTerdaftar == false) {
            $clockedInStatus = 'ClockedIn';
            $isClockedIn = $activity->sukarelawan_activity_details
                ->where('sukarelawanActivityStatus.name', $clockedInStatus)
                ->where('sukarelawanId', auth()->user()->sukarelawan->id)
                ->isNotEmpty();
        }
    
        if ($isTerdaftar && $isClockedIn == false) {
            $claimedStatus = 'Claimed';
            $isClaimed = $activity->sukarelawan_activity_details
                ->where('sukarelawanActivityStatus.name', $claimedStatus)
                ->where('sukarelawanId', auth()->user()->sukarelawan->id)
                ->isNotEmpty();
        }
    
        // Check if the user has liked the activity
        $isLiked = $activity->sukarelawan_activity_details
            ->where('isLiked', true)
            ->where('sukarelawanId', auth()->user()->sukarelawan->id)
            ->isNotEmpty();
    }
@endphp
@php
    // NOTE: Buat checking apakah Sukarelawan udh bisa ClockIn / Clockout
@endphp

@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#groupLinkModal">
        Open Modal
    </button> --}}
    <div class="modal" id="groupLinkModal">
        <div class="modal-content">
            <div class="modal-content-body">
                <h3>Scan QR code</h3>
                <p class="disable">
                    Masuk ke dalam group chat
                </p>
                <div class="barcode-container">
                    @php
                        //TODO: Barcode script here:
                    @endphp
                    <img src="" alt="">
                </div>
                <p class="disable">
                    atau tekan tautan dibawah ini
                </p>
                <div class="row">
                    <a href="{{ 'linkGrupWA' }}" class="selected">{{ 'linkGrupWA' }}</a>
                </div>
                <button type="button" class="btn-fill full" data-dismiss="modal">
                    Sudah Bergabung
                </button>
            </div>
        </div>
    </div>
    {{-- Modal will not be used... --}}

    <div class="activities-body">
        <div class="col">
            <div class="content-card-center">
                <div class="img-container"
                    style="background-image: url('{{ asset(
                        $activity->bannerImageUrl
                            ? 'storage/images/' . $activity->bannerImageUrl
                            : '/images/' . Config::get('constants.default_banner_image'),
                    ) }}');">
                    <form method="POST" action="{{ route('activities.like', ['activity' => $activity->slug]) }}">
                        @csrf
                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                            <div
                                class="likes
                                @if ($isLiked) {{ 'liked' }} @endif
                            ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 22 21"
                                    fill="none">
                                    <path
                                        d="M5.383 9.75C6.189 9.75 6.916 9.304 7.414 8.67C8.19026 7.67962 9.16471 6.86218 10.275 6.27C10.998 5.886 11.625 5.314 11.928 4.555C12.1408 4.02325 12.2501 3.45575 12.25 2.883V2.25C12.25 2.05109 12.329 1.86032 12.4697 1.71967C12.6103 1.57902 12.8011 1.5 13 1.5C13.5967 1.5 14.169 1.73705 14.591 2.15901C15.013 2.58097 15.25 3.15326 15.25 3.75C15.25 4.902 14.99 5.993 14.527 6.968C14.261 7.526 14.634 8.25 15.252 8.25H18.378C19.404 8.25 20.323 8.944 20.432 9.965C20.477 10.387 20.5 10.815 20.5 11.25C20.5041 13.9863 19.5691 16.6412 17.851 18.771C17.463 19.253 16.864 19.5 16.246 19.5H12.23C11.7464 19.4998 11.266 19.4221 10.807 19.27L7.693 18.23C7.23411 18.0774 6.75361 17.9997 6.27 18H4.654M4.654 18C4.737 18.205 4.827 18.405 4.924 18.602C5.121 19.002 4.846 19.5 4.401 19.5H3.493C2.604 19.5 1.78 18.982 1.521 18.132C1.17465 16.9952 0.999065 15.8133 1 14.625C1 13.072 1.295 11.589 1.831 10.227C2.137 9.453 2.917 9 3.75 9H4.803C5.275 9 5.548 9.556 5.303 9.96C4.44889 11.366 3.99843 12.9799 4.001 14.625C3.99937 15.7816 4.22145 16.9277 4.655 18H4.654ZM13 8.25H15.25"
                                        stroke="

                                        @if ($isLiked) #FFFFFF
                                        @else
                                        #5822CA @endif
                                        "
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p id="likeCount">{{ $activity->likeCount() }}</p>
                            </div>
                        </button>
                    </form>
                </div>


                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 19"
                        fill="none">
                        <path
                            d="M11 15C11 14.8689 10.9742 14.7389 10.924 14.6177C10.8738 14.4965 10.8002 14.3864 10.7074 14.2936C10.6147 14.2009 10.5045 14.1273 10.3833 14.0771C10.2621 14.0269 10.1322 14.001 10.001 14.001C9.86983 14.001 9.73993 14.0269 9.61872 14.0771C9.49752 14.1273 9.38739 14.2009 9.29462 14.2936C9.20186 14.3864 9.12827 14.4965 9.07807 14.6177C9.02786 14.7389 9.00202 14.8689 9.00202 15C9.01023 15.2594 9.11903 15.5054 9.30539 15.6859C9.49175 15.8665 9.74104 15.9674 10.0005 15.9674C10.26 15.9674 10.5093 15.8665 10.6957 15.6859C10.882 15.5054 10.9908 15.2594 10.999 15H11ZM10.74 7.14705C10.7141 6.95871 10.6176 6.78724 10.4701 6.66732C10.3226 6.5474 10.1351 6.48797 9.94541 6.50105C9.75575 6.51414 9.57813 6.59876 9.44848 6.7378C9.31884 6.87685 9.24683 7.05994 9.24702 7.25005L9.25102 11.751L9.25802 11.853C9.28394 12.0414 9.3804 12.2129 9.52792 12.3328C9.67543 12.4527 9.86298 12.5121 10.0526 12.499C10.2423 12.486 10.4199 12.4013 10.5496 12.2623C10.6792 12.1232 10.7512 11.9402 10.751 11.75L10.747 7.24805L10.74 7.14705ZM11.97 1.65905C11.113 0.111047 8.88802 0.111047 8.03202 1.65905L0.286024 15.66C-0.543976 17.16 0.541024 19 2.25602 19H17.746C19.46 19 20.545 17.16 19.715 15.66L11.969 1.66005L11.97 1.65905ZM9.34402 2.38505C9.40884 2.2677 9.50393 2.16987 9.61939 2.10175C9.73485 2.03362 9.86646 1.99769 10.0005 1.99769C10.1346 1.99769 10.2662 2.03362 10.3817 2.10175C10.4971 2.16987 10.5922 2.2677 10.657 2.38505L18.402 16.387C18.4652 16.5012 18.4974 16.6299 18.4957 16.7603C18.4939 16.8908 18.4581 17.0185 18.3918 17.1309C18.3256 17.2433 18.2312 17.3364 18.1179 17.4012C18.0047 17.4659 17.8765 17.5 17.746 17.5H2.25602C2.12548 17.5002 1.99717 17.4662 1.88377 17.4015C1.77037 17.3369 1.67582 17.2437 1.60946 17.1313C1.5431 17.0189 1.50723 16.8911 1.5054 16.7606C1.50357 16.63 1.53584 16.5013 1.59902 16.387L9.34402 2.38505Z"
                            fill="#E21919" />
                    </svg>
                    <?php
                    $registrationDate = Carbon::parse($activity->registrationDeadlineDate);
                    $formattedDateregistrationDeadlineDate = $registrationDate->format('j M Y');
                    ?>
                    <p class="danger batas">Batas Registrasi: {{ $formattedDateregistrationDeadlineDate }}</p>
                </div>

                @php
                    $today = Carbon::now();
                    $registrationDate = Carbon::parse($activity->registrationDeadlineDate);
                    $isPassedMaxRegistrationDate = false;
                    
                    if ($today->gt($registrationDate)) {
                        $isPassedMaxRegistrationDate = true;
                    }
                @endphp
                <div class="btn-container">
                    @if ($isPassedMaxRegistrationDate)
                        <div class="btn-fill full bg-disabled">Registrasi Telah Ditutup</div>
                    @elseif (auth()->user()->sukarelawan->verificationStatus->name != 'Sudah Diverifikasi')
                        <div class="btn-fill full bg-disabled">Anda
                            {{ auth()->user()->sukarelawan->verificationStatus->name }}</div>
                    @else
                        @if ($isTerdaftar && !$isClockedIn)
                            <form method="POST" action="{{ route('activities.unjoin', ['activity' => $activity->slug]) }}">
                                @csrf
                                <button type="submit" class="btn-fill full bg-danger"
                                    onclick="return confirm('Apakah Anda yakin untuk membatalkan pendaftaran pada aktivitas ini?');">Batalkan
                                    Pendaftaran</button>
                            </form>
                        @else
                            @if (!$isClockedIn)
                                <form method="POST"
                                    action="{{ route('activities.join', ['activity' => $activity->slug]) }}">
                                    @csrf
                                    <button type="submit" class="btn-fill full">Daftar Aktivitas</button>
                                </form>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
            {{-- Lowongan Sukarelawan --}}
            <div class="content-card">
                <h5>
                    Lowongan Sukarelawan
                </h5>
                <p>
                    {{ $activity->joinedSukarelawanCount() }} dari {{ $activity->minimumNumOfSukarelawan }}
                </p>
                <div class="progress-bar">
                    @php
                        $joinedPercentage = ceil($activity->joinedSukarelawanCount() / $activity->minimumNumOfSukarelawan) * 10;
                    @endphp
                    <div class="progress-fill" style="width: {{ $joinedPercentage }}%">
                    </div>
                </div>
            </div>

            @if ($isTerdaftar || $isClockedIn)
                {{-- Link Group --}}
                <div class="content-card">
                    <div class="row-spaced">
                        <h5>Link Group</h5>
                        <input id="groupChatUrl" value="{{ $activity->groupChatUrl }}" type="hidden">
                        <div class="tooltip">
                            <button onclick="copyGroupChatUrl()">
                                <span class="tooltiptext" id="myTooltip">Copy Link</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.6001 15.1996C1.6001 15.8361 1.85295 16.4466 2.30304 16.8967C2.75313 17.3468 3.36358 17.5996 4.0001 17.5996H6.4001V15.9996H4.0001C3.78792 15.9996 3.58444 15.9153 3.43441 15.7653C3.28438 15.6153 3.2001 15.4118 3.2001 15.1996V3.99961C3.2001 3.78744 3.28438 3.58395 3.43441 3.43392C3.58444 3.28389 3.78792 3.19961 4.0001 3.19961H15.2001C15.4123 3.19961 15.6158 3.28389 15.7658 3.43392C15.9158 3.58395 16.0001 3.78744 16.0001 3.99961V6.39961H8.8001C8.16358 6.39961 7.55313 6.65247 7.10304 7.10255C6.65295 7.55264 6.4001 8.16309 6.4001 8.79961V19.9996C6.4001 20.6361 6.65295 21.2466 7.10304 21.6967C7.55313 22.1468 8.16358 22.3996 8.8001 22.3996H20.0001C20.6366 22.3996 21.2471 22.1468 21.6972 21.6967C22.1472 21.2466 22.4001 20.6361 22.4001 19.9996V8.79961C22.4001 8.16309 22.1472 7.55264 21.6972 7.10255C21.2471 6.65247 20.6366 6.39961 20.0001 6.39961H17.6001V3.99961C17.6001 3.36309 17.3472 2.75264 16.8972 2.30255C16.4471 1.85247 15.8366 1.59961 15.2001 1.59961H4.0001C3.36358 1.59961 2.75313 1.85247 2.30304 2.30255C1.85295 2.75264 1.6001 3.36309 1.6001 3.99961V15.1996ZM8.0001 8.79961C8.0001 8.58744 8.08438 8.38395 8.23441 8.23392C8.38444 8.08389 8.58792 7.99961 8.8001 7.99961H20.0001C20.2123 7.99961 20.4158 8.08389 20.5658 8.23392C20.7158 8.38395 20.8001 8.58744 20.8001 8.79961V19.9996C20.8001 20.2118 20.7158 20.4153 20.5658 20.5653C20.4158 20.7153 20.2123 20.7996 20.0001 20.7996H8.8001C8.58792 20.7996 8.38444 20.7153 8.23441 20.5653C8.08438 20.4153 8.0001 20.2118 8.0001 19.9996V8.79961Z"
                                        fill="#838181" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <a href="{{ $activity->groupChatUrl }}" target="_blank">{{ 'Open Group Link' }}</a>
                    <div class="barcode-container">
                        <div class="visible-print text-center">
                            {!! QrCode::size(200)->generate("$activity->groupChatUrl") !!}
                        </div>
                    </div>
                </div>
            @endif

        </div>


        <div class="col">
            <h1>
                {{ $activity->name }}
            </h1>
            {{-- Absensi --}}
            @if ($isTerdaftar || $isClockedIn || $isClaimed)
                <div class="content-card cclg">
                    <div class="absensi" style="background-image: url('{{ asset('/images/absensi_bg.png') }}');">
                        <h5>
                            Absensi
                        </h5>
                        <div class="row">
                            <div
                                class="clock-time-container clockin

                            {{ $isClockedIn || $isClaimed ? 'success' : '' }}

                            ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="53" height="53" viewBox="0 0 53 53"
                                    fill="none">
                                    <path
                                        d="M38.9322 28.8208C38.9322 28.471 38.7932 28.1356 38.5459 27.8882C38.2986 27.6409 37.9631 27.502 37.6133 27.502C37.2635 27.502 36.9281 27.6409 36.6807 27.8882C36.4334 28.1356 36.2944 28.471 36.2944 28.8208V37.6133C36.2943 37.8369 36.3511 38.0569 36.4594 38.2525C36.5677 38.4482 36.7239 38.6131 36.9134 38.7317L42.1889 42.0289C42.4855 42.2145 42.8437 42.2747 43.1847 42.1962C43.3536 42.1574 43.5131 42.0856 43.6542 41.9851C43.7954 41.8846 43.9153 41.7573 44.0072 41.6104C44.0991 41.4635 44.1612 41.3 44.1899 41.1291C44.2186 40.9583 44.2134 40.7834 44.1745 40.6146C44.1357 40.4457 44.0639 40.2862 43.9634 40.1451C43.8629 40.0039 43.7356 39.884 43.5887 39.7921L38.9322 36.8818V28.8208Z"
                                        fill="
                                        {{ $isClockedIn || $isClaimed ? '#38d46d' : '#D88B4C' }}
                                        " />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M37.6134 22.2266C33.5327 22.2266 29.6191 23.8477 26.7336 26.7333C23.8481 29.6189 22.2271 33.5326 22.2271 37.6134C22.2271 41.6943 23.8481 45.608 26.7336 48.4936C29.6191 51.3792 33.5327 53.0003 37.6134 53.0003C41.6941 53.0003 45.6077 51.3792 48.4932 48.4936C51.3787 45.608 52.9998 41.6943 52.9998 37.6134C52.9998 33.5326 51.3787 29.6189 48.4932 26.7333C45.6077 23.8477 41.6941 22.2266 37.6134 22.2266ZM24.8647 37.6134C24.8647 35.9392 25.1945 34.2813 25.8351 32.7346C26.4758 31.1878 27.4149 29.7823 28.5987 28.5984C29.7825 27.4146 31.188 26.4755 32.7347 25.8348C34.2814 25.1941 35.9392 24.8643 37.6134 24.8643C39.2876 24.8643 40.9454 25.1941 42.4921 25.8348C44.0389 26.4755 45.4443 27.4146 46.6281 28.5984C47.8119 29.7823 48.751 31.1878 49.3917 32.7346C50.0324 34.2813 50.3621 35.9392 50.3621 37.6134C50.3621 40.9947 49.0189 44.2375 46.6281 46.6284C44.2373 49.0193 40.9946 50.3625 37.6134 50.3625C34.2322 50.3625 30.9896 49.0193 28.5987 46.6284C26.2079 44.2375 24.8647 40.9947 24.8647 37.6134Z"
                                        fill="
                                        {{ $isClockedIn || $isClaimed ? '#38d46d' : '#D88B4C' }}
                                        " />
                                    <path
                                        d="M24.1778 24.1784L9.67119 24.1784M24.1778 24.1784L24.1778 9.67125M24.1778 24.1784L7.25342 7.2534"
                                        stroke="
                                        {{ $isClockedIn || $isClaimed ? '#38d46d' : '#D88B4C' }}
                                        "
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="col-sm">
                                    <h5>Waktu Acara Dimulai</h5>
                                    <h2>
                                        {{ substr($activity->startTime, 0, 5) }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->sukarelawan->verificationStatus->name == 'Sudah Diverifikasi')
                            @if ($activity->isEligibleForClockIn() || $isClockedIn || $isClaimed)
                                @if ($isClockedIn || $isClaimed)
                                    @if ($isClockedIn)
                                        <div class="btn-fill clockin">
                                            Absensi Tercatat
                                        </div>
                                        <div class="caption">
                                            Menunggu verifikasi absensi Anda dari Fasilitator
                                        </div>
                                    @else
                                        <div class="btn-fill clockin success">
                                            Berhasil Menyelesaikan Aktivitas
                                        </div>
                                        <div class="caption">
                                            Terima kasih atas kontribusi Anda
                                        </div>
                                    @endif
                                @else
                                    <form action="{{ route('activities.attend', ['activity' => $activity->slug]) }}"
                                        class="no-style-form" method="post">
                                        @csrf
                                        {{-- <input type="hidden" name="isWithinGatherRadius" id="isWithinGatherRadius"> --}}

                                        <button type="submit" class="btn-fill absensi-btn">
                                            Absen Kehadiran
                                        </button>
                                    </form>
                                    <div class="caption">
                                        Pastikan Anda sudah berada di titik kumpul
                                    </div>
                                @endif
                            @else
                                <div class="btn-fill bg-disabled">
                                    Absensi Belum Dibuka
                                </div>
                                <div class="caption">
                                    Absensi hanya dibuka 30 menit sebelum dan sesudah aktivitas dimulai
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            <div class="row">
                {{-- Tempat Tanggal --}}
                <div class="content-card ccmd">
                    <h5>
                        Tempat dan Tanggal Aktivitas
                    </h5>
                    <div class="row-spaced">
                        <div class="row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M12.2 13.4C13.6912 13.4 14.9 12.1912 14.9 10.7C14.9 9.20883 13.6912 8 12.2 8C10.7088 8 9.5 9.20883 9.5 10.7C9.5 12.1912 10.7088 13.4 12.2 13.4Z"
                                    stroke="#838181" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12.2 3.5C10.2904 3.5 8.45909 4.25857 7.10883 5.60883C5.75857 6.95909 5 8.79044 5 10.7C5 12.4028 5.3618 13.517 6.35 14.75L12.2 21.5L18.05 14.75C19.0382 13.517 19.4 12.4028 19.4 10.7C19.4 8.79044 18.6414 6.95909 17.2912 5.60883C15.9409 4.25857 14.1096 3.5 12.2 3.5Z"
                                    stroke="#838181" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p>
                                {{ $activity->river->name }}
                            </p>
                        </div>
                        {{-- LINK G MAPS --}}
                        <a href="{{ $activity->river->locationUrl }}" target="_blank">Tampilkan rute di Peta</a>
                    </div>
                    <div class="row-spaced">
                        <div class="row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M3 11.7693C3 8.28843 3 6.54752 4.08184 5.46661C5.16276 4.38477 6.90367 4.38477 10.3846 4.38477H14.0769C17.5578 4.38477 19.2987 4.38477 20.3796 5.46661C21.4614 6.54752 21.4614 8.28843 21.4614 11.7693V13.6155C21.4614 17.0964 21.4614 18.8373 20.3796 19.9182C19.2987 21.0001 17.5578 21.0001 14.0769 21.0001H10.3846C6.90367 21.0001 5.16276 21.0001 4.08184 19.9182C3 18.8373 3 17.0964 3 13.6155V11.7693Z"
                                    stroke="#838181" stroke-width="1.5" />
                                <path d="M7.61525 4.38461V3M16.846 4.38461V3M3.46143 8.99996H20.9998" stroke="#838181"
                                    stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M17.7692 16.3849C17.7692 16.6297 17.672 16.8645 17.4989 17.0376C17.3258 17.2107 17.091 17.308 16.8462 17.308C16.6014 17.308 16.3666 17.2107 16.1935 17.0376C16.0203 16.8645 15.9231 16.6297 15.9231 16.3849C15.9231 16.1401 16.0203 15.9053 16.1935 15.7322C16.3666 15.5591 16.6014 15.4618 16.8462 15.4618C17.091 15.4618 17.3258 15.5591 17.4989 15.7322C17.672 15.9053 17.7692 16.1401 17.7692 16.3849ZM17.7692 12.6926C17.7692 12.9374 17.672 13.1722 17.4989 13.3453C17.3258 13.5184 17.091 13.6157 16.8462 13.6157C16.6014 13.6157 16.3666 13.5184 16.1935 13.3453C16.0203 13.1722 15.9231 12.9374 15.9231 12.6926C15.9231 12.4478 16.0203 12.213 16.1935 12.0399C16.3666 11.8668 16.6014 11.7695 16.8462 11.7695C17.091 11.7695 17.3258 11.8668 17.4989 12.0399C17.672 12.213 17.7692 12.4478 17.7692 12.6926ZM13.1539 16.3849C13.1539 16.6297 13.0566 16.8645 12.8835 17.0376C12.7104 17.2107 12.4756 17.308 12.2308 17.308C11.986 17.308 11.7512 17.2107 11.5781 17.0376C11.405 16.8645 11.3077 16.6297 11.3077 16.3849C11.3077 16.1401 11.405 15.9053 11.5781 15.7322C11.7512 15.5591 11.986 15.4618 12.2308 15.4618C12.4756 15.4618 12.7104 15.5591 12.8835 15.7322C13.0566 15.9053 13.1539 16.1401 13.1539 16.3849ZM13.1539 12.6926C13.1539 12.9374 13.0566 13.1722 12.8835 13.3453C12.7104 13.5184 12.4756 13.6157 12.2308 13.6157C11.986 13.6157 11.7512 13.5184 11.5781 13.3453C11.405 13.1722 11.3077 12.9374 11.3077 12.6926C11.3077 12.4478 11.405 12.213 11.5781 12.0399C11.7512 11.8668 11.986 11.7695 12.2308 11.7695C12.4756 11.7695 12.7104 11.8668 12.8835 12.0399C13.0566 12.213 13.1539 12.4478 13.1539 12.6926ZM8.53853 16.3849C8.53853 16.6297 8.44127 16.8645 8.26816 17.0376C8.09505 17.2107 7.86027 17.308 7.61545 17.308C7.37064 17.308 7.13585 17.2107 6.96274 17.0376C6.78963 16.8645 6.69238 16.6297 6.69238 16.3849C6.69238 16.1401 6.78963 15.9053 6.96274 15.7322C7.13585 15.5591 7.37064 15.4618 7.61545 15.4618C7.86027 15.4618 8.09505 15.5591 8.26816 15.7322C8.44127 15.9053 8.53853 16.1401 8.53853 16.3849ZM8.53853 12.6926C8.53853 12.9374 8.44127 13.1722 8.26816 13.3453C8.09505 13.5184 7.86027 13.6157 7.61545 13.6157C7.37064 13.6157 7.13585 13.5184 6.96274 13.3453C6.78963 13.1722 6.69238 12.9374 6.69238 12.6926C6.69238 12.4478 6.78963 12.213 6.96274 12.0399C7.13585 11.8668 7.37064 11.7695 7.61545 11.7695C7.86027 11.7695 8.09505 11.8668 8.26816 12.0399C8.44127 12.213 8.53853 12.4478 8.53853 12.6926Z"
                                    fill="#838181" />
                            </svg>
                            <p>
                                <?php
                                $cleanUpDate = Carbon::parse($activity->cleanUpDate);
                                $formattedCleanUpDate = $cleanUpDate->format('j M Y');
                                ?>
                                {{ $formattedCleanUpDate }}
                            </p>
                        </div>
                        {{-- LINK G Calendar --}}
                        @php
                            $eventDetails = 'Gathering Point Location';
                            $encodedEventDetails = urlencode("$eventDetails\nGoogle Maps: $activity->gatheringPointUrl");
                            
                            $formattedStartDate = date('Ymd\THis', strtotime($activity->cleanUpDate . ' ' . $activity->startTime));
                            $formattedEndDate = date('Ymd\THis', strtotime($activity->cleanUpDate . ' ' . $activity->endTime));
                            
                            $googleCalendarUrl = 'https://www.google.com/calendar/render?action=TEMPLATE' . '&text=' . urlencode($activity->name) . "&dates=$formattedStartDate/$formattedEndDate" . "&details=$encodedEventDetails" . '&location=' . urlencode($activity->river->name);
                        @endphp
                        <a href="{{ $googleCalendarUrl }}" target="_blank">Tambahkan
                            Jadwal ke Kalendar</a>
                    </div>
                    <div class="row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M12.7714 6.85737C12.7714 6.65277 12.6901 6.45655 12.5454 6.31188C12.4008 6.16721 12.2045 6.08594 11.9999 6.08594C11.7953 6.08594 11.5991 6.16721 11.4545 6.31188C11.3098 6.45655 11.2285 6.65277 11.2285 6.85737V12.0002C11.2285 12.131 11.2617 12.2597 11.325 12.3741C11.3883 12.4885 11.4797 12.585 11.5906 12.6544L14.6763 14.583C14.8498 14.6915 15.0593 14.7267 15.2588 14.6808C15.3575 14.6581 15.4508 14.6161 15.5334 14.5573C15.6159 14.4986 15.6861 14.4241 15.7398 14.3382C15.7936 14.2523 15.8299 14.1566 15.8467 14.0567C15.8635 13.9567 15.8604 13.8545 15.8377 13.7557C15.815 13.6569 15.773 13.5636 15.7142 13.4811C15.6554 13.3985 15.5809 13.3284 15.495 13.2746L12.7714 11.5723V6.85737Z"
                                fill="#838181" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 3C9.61305 3 7.32387 3.94821 5.63604 5.63604C3.94821 7.32387 3 9.61305 3 12C3 14.3869 3.94821 16.6761 5.63604 18.364C7.32387 20.0518 9.61305 21 12 21C14.3869 21 16.6761 20.0518 18.364 18.364C20.0518 16.6761 21 14.3869 21 12C21 9.61305 20.0518 7.32387 18.364 5.63604C16.6761 3.94821 14.3869 3 12 3ZM4.54286 12C4.54286 11.0207 4.73574 10.051 5.1105 9.14628C5.48525 8.24153 6.03454 7.41946 6.727 6.727C7.41946 6.03454 8.24153 5.48525 9.14628 5.1105C10.051 4.73574 11.0207 4.54286 12 4.54286C12.9793 4.54286 13.949 4.73574 14.8537 5.1105C15.7585 5.48525 16.5805 6.03454 17.273 6.727C17.9655 7.41946 18.5147 8.24153 18.8895 9.14628C19.2643 10.051 19.4571 11.0207 19.4571 12C19.4571 13.9778 18.6715 15.8745 17.273 17.273C15.8745 18.6715 13.9778 19.4571 12 19.4571C10.0222 19.4571 8.12549 18.6715 6.727 17.273C5.32852 15.8745 4.54286 13.9778 4.54286 12Z"
                                fill="#838181" />
                        </svg>
                        <p>
                            {{ \Carbon\Carbon::parse($activity->startTime)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($activity->endTime)->format('H:i') }} WIB
                        </p>
                    </div>
                </div>
                {{-- Kontak --}}
                <div class="content-card ccsm">
                    <h5>
                        Kontak Fasilitator
                    </h5>
                    <div class="row">
                        <div class="profpic">
                            <img src="{{ asset('storage/images/' . $activity->fasilitator->logoImageUrl) }}"
                                alt="">
                        </div>
                        <a href="/fasilitators/{{ $activity->fasilitator->slug }}" class="selected">
                            <p class="selected">
                                {{ $activity->fasilitator->user->name }}
                            </p>
                        </a>
                    </div>
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
                        {{ $activity->fasilitator->user->email }}
                    </div>
                    <div class="row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M21.9999 16.9201V19.9201C22.0011 20.1986 21.944 20.4743 21.8324 20.7294C21.7209 20.9846 21.5572 21.2137 21.352 21.402C21.1468 21.5902 20.9045 21.7336 20.6407 21.8228C20.3769 21.912 20.0973 21.9452 19.8199 21.9201C16.7428 21.5857 13.7869 20.5342 11.1899 18.8501C8.77376 17.3148 6.72527 15.2663 5.18993 12.8501C3.49991 10.2413 2.44818 7.27109 2.11993 4.1801C2.09494 3.90356 2.12781 3.62486 2.21643 3.36172C2.30506 3.09859 2.4475 2.85679 2.6347 2.65172C2.82189 2.44665 3.04974 2.28281 3.30372 2.17062C3.55771 2.05843 3.83227 2.00036 4.10993 2.0001H7.10993C7.59524 1.99532 8.06572 2.16718 8.43369 2.48363C8.80166 2.80008 9.04201 3.23954 9.10993 3.7201C9.23656 4.68016 9.47138 5.62282 9.80993 6.5301C9.94448 6.88802 9.9736 7.27701 9.89384 7.65098C9.81408 8.02494 9.6288 8.36821 9.35993 8.6401L8.08993 9.9101C9.51349 12.4136 11.5864 14.4865 14.0899 15.9101L15.3599 14.6401C15.6318 14.3712 15.9751 14.1859 16.3491 14.1062C16.723 14.0264 17.112 14.0556 17.4699 14.1901C18.3772 14.5286 19.3199 14.7635 20.2799 14.8901C20.7657 14.9586 21.2093 15.2033 21.5265 15.5776C21.8436 15.9519 22.0121 16.4297 21.9999 16.9201Z"
                                stroke="#838181" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        +62 {{ $activity->fasilitator->phoneNumber }}
                    </div>
                </div>
            </div>
            {{-- Deskripsi --}}
            <div class="content-card cclg">
                <h5>
                    Deskripsi Aktivitas
                </h5>
                <p>
                    {{ $activity->description }}
                </p>
            </div>
            {{-- Pekerjaan --}}
            <div class="content-card cclg">
                <h5>
                    Pekerjaan Sukarelawan
                </h5>
                <p class="sub-header">
                    Nama Pekerjaan
                </p>
                <p>
                    {{ $activity->sukarelawanJobName }}
                </p>
                <p class="sub-header">
                    Tugas Relawan
                </p>
                <p>
                    {{ $activity->sukarelawanJobDetail }}
                </p>
            </div>
            {{-- Kriteria Sukarelawan --}}
            <div class="content-card cclg">
                <h5>
                    Kriteria Sukarelawan
                </h5>
                @php
                    $criteriaCounter = 1;
                @endphp

                @foreach ($sukarelawanCriteria as $criteria)
                    <li>
                        <p class="number">{{ $criteriaCounter }}</p>
                        <p>{{ $criteria }}</p>
                    </li>
                    @php
                        $criteriaCounter++;
                    @endphp
                @endforeach
            </div>
            {{-- Perlengkapan --}}
            <div class="content-card cclg">
                <h5>
                    Perlengkapan Sukarelawan
                </h5>
                <div class="perlengkapan-container">
                    @php
                        $perCounter = 1;
                    @endphp

                    @foreach ($sukarelawanEquipment as $equipment)
                        <div class="perlengkapan">
                            {{ $equipment }}
                        </div>
                        @php
                            $perCounter++;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="{{ asset('js/likeActivity.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/checkLocation.js') }}"></script> --}}


    <script>
        function copyGroupChatUrl() {
            var copyText = document.getElementById("groupChatUrl");
            copyText.type = "text";
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            copyText.type = "hidden";


            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copied: " + copyText.value;
        }
    </script>
@endsection
