@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/sukarelawan.css') }}" />
@endsection




@section('content')
    <h1 class="mt-3">Profil Fasilitator</h1>
    <div class="sukarelawan-row">
        <div class="sukarelawan-col">
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content">
                    <div class="profpic">
                        <img src="{{ asset($fasilitator->logoImageUrl ? 'storage/images/' . $fasilitator->logoImageUrl : '/images/' . Config::get('constants.default_logo_image')) }}"
                            alt="Fasilitator Profile Picture">
                    </div>
                    <div class="profile-col">
                        <h1>{{ $fasilitator->user->name }}</h1>
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
                            <p>{{ $fasilitator->user->email }}</p>
                        </div>

                        @if (auth()->user() && auth()->user()->fasilitator && auth()->user()->fasilitator->id == $fasilitator->id)
                            <div class="row">
                                <a href="/change-password/{{ $fasilitator->slug }}">
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
                        @endif
                    </div>
                    @if (auth()->user() && auth()->user()->fasilitator && auth()->user()->fasilitator->id == $fasilitator->id)
                        <a href="{{ $fasilitator->slug }}/edit">
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
                    @endif
                </div>
            </div>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content col">
                    <h3>Identitas</h3>
                    <div class="col fs">
                        <p class="disabled">
                            Tipe
                        </p>
                        <p>
                            {{ $fasilitator->fasilitatorType->name }}
                        </p>
                    </div>

                    <div class="col fs">
                        <p class="disabled">
                            Deskripsi
                        </p>
                        <p>
                            {{ $fasilitator->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sukarelawan-col">
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content col">
                    <h3>Kontak</h3>

                    <div class="row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M12.2 13.4C13.6912 13.4 14.9 12.1912 14.9 10.7C14.9 9.20883 13.6912 8 12.2 8C10.7088 8 9.5 9.20883 9.5 10.7C9.5 12.1912 10.7088 13.4 12.2 13.4Z"
                                stroke="#838181" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12.2 3.5C10.2904 3.5 8.45909 4.25857 7.10883 5.60883C5.75857 6.95909 5 8.79044 5 10.7C5 12.4028 5.3618 13.517 6.35 14.75L12.2 21.5L18.05 14.75C19.0382 13.517 19.4 12.4028 19.4 10.7C19.4 8.79044 18.6414 6.95909 17.2912 5.60883C15.9409 4.25857 14.1096 3.5 12.2 3.5Z"
                                stroke="#838181" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>{{ $fasilitator->address }}</p>
                    </div>
                    <div class="row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                            fill="none">
                            <path
                                d="M16.9995 12.9791V15.3877C17.0004 15.6113 16.9545 15.8327 16.8648 16.0375C16.775 16.2424 16.6434 16.4263 16.4783 16.5775C16.3132 16.7286 16.1183 16.8437 15.906 16.9154C15.6938 16.987 15.4689 17.0136 15.2457 16.9935C12.7702 16.725 10.3923 15.8808 8.30312 14.5286C6.35937 13.2959 4.71141 11.6512 3.47627 9.71134C2.11669 7.61679 1.27059 5.23206 1.00653 2.75036C0.986426 2.52834 1.01286 2.30457 1.08416 2.0933C1.15546 1.88203 1.27005 1.6879 1.42065 1.52325C1.57124 1.35861 1.75454 1.22706 1.95886 1.13699C2.16319 1.04691 2.38407 1.00029 2.60744 1.00008H5.02086C5.41128 0.996243 5.78977 1.13422 6.0858 1.3883C6.38182 1.64237 6.57517 1.99521 6.62981 2.38103C6.73168 3.15185 6.92059 3.9087 7.19295 4.63713C7.30118 4.9245 7.32461 5.23682 7.26045 5.53707C7.19629 5.83732 7.04723 6.11292 6.83093 6.33121L5.80925 7.35087C6.95447 9.36092 8.62206 11.0252 10.6361 12.1682L11.6578 11.1485C11.8765 10.9326 12.1527 10.7839 12.4535 10.7198C12.7544 10.6558 13.0673 10.6792 13.3552 10.7872C14.0851 11.059 14.8435 11.2476 15.6158 11.3492C16.0066 11.4042 16.3635 11.6007 16.6186 11.9012C16.8737 12.2017 17.0093 12.5853 16.9995 12.9791Z"
                                stroke="#838181" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>(+62) {{ $fasilitator->phoneNumber }}</p>
                    </div>
                </div>

            </div>
            <div class="sukarelawan-card-container">
                <div class="sukarelawan-card-content col status-aktivitas">
                    <h3>Pengalaman</h3>
                    <div class="col fs">
                        {{-- get aktivitas status ClockedIn --}}
                        <h2 class="biru">{{ $openActivities->count() }} aktivitas</h2>
                        <p>membuka pendaftaran</p>
                    </div>
                    <div class="col fs">
                        {{-- get aktivitas status Claimed --}}
                        <h2 class="hijau">{{ $finishActivitiesCount }} aktivitas</h2>
                        <p>sukses diselenggarakan</p>
                    </div>
                    <div class="col fs">
                        {{-- get aktivitas status ClockedIn --}}
                        <h2 class="merah">{{ $ongoingActivities->count() }} aktivitas</h2>
                        <p>sedang diselenggarakan</p>
                    </div>

                    @if (auth()->user() && auth()->user()->fasilitator && auth()->user()->fasilitator->id == $fasilitator->id)
                        <div class="row">
                            <a href="/fasilitators/{{ $fasilitator->slug }}/manage">
                                <div class="btn-fill">
                                    Aktivitas Dibuat
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-3">Aktivitas yang membuka pendaftaran</h3>
    <div class="sukarelawan-activities-row">
        @if ($openActivities != null && $openActivities->count() > 0)
            @foreach ($openActivities as $activity)
                <x-activity-card :activity="$activity" />
            @endforeach
        @else
            <h2 class="disabled">
                Belum ada aktivitas
            </h2>
        @endif
    </div>

    <h3 class="mt-3">Aktivitas yang sedang berjalan</h3>
    <div class="sukarelawan-activities-row">
        @if ($ongoingActivities != null && $ongoingActivities->count() > 0)
            @foreach ($ongoingActivities as $activity)
                <x-activity-card :activity="$activity" />
            @endforeach
        @else
            <h2 class="disabled">
                Belum ada aktivitas
            </h2>
        @endif
    </div>
@endsection
