@extends('public.fasilitator.finalizeAttendance.finalizeSukarelawanAttendance')

@section('Fasilitator.finalizeAttendance')
    <div class="activity-container">
        @if ($activity->bannerImageUrl !== null)
            <img src={{ asset('storage/images/' . $activity->bannerImageUrl) }} class="activity-image" alt="">
        @else
            <img src={{ asset('images/Activity/bannerImages/default.png') }} alt="{{ $activity->name }}"
                class="activity-image">
        @endif
        <div class="activity-container-content">
            <div class="card-row">
                <h3>{{ $activity->name }}</h3>
                <img src={{ asset('images/FinalizeAttendance/verified-activity.png') }} alt=""
                    class="verified-activity">
            </div>
            <div class="activity-content-detail-row">
                <div class="activity-content-detail-column">
                    <div class="card-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <g clip-path="url(#clip0_434_1084)">
                                <path
                                    d="M1 9.76934C1 6.28843 1 4.54752 2.08184 3.46661C3.16276 2.38477 4.90367 2.38477 8.38457 2.38477H12.0769C15.5578 2.38477 17.2987 2.38477 18.3796 3.46661C19.4614 4.54752 19.4614 6.28843 19.4614 9.76934V11.6155C19.4614 15.0964 19.4614 16.8373 18.3796 17.9182C17.2987 19.0001 15.5578 19.0001 12.0769 19.0001H8.38457C4.90367 19.0001 3.16276 19.0001 2.08184 17.9182C1 16.8373 1 15.0964 1 11.6155V9.76934Z"
                                    stroke="#838181" stroke-width="1.5" />
                                <path d="M5.61549 2.38461V1M14.8462 2.38461V1M1.46167 6.99996H19" stroke="#838181"
                                    stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M15.7692 14.3844C15.7692 14.6292 15.672 14.864 15.4989 15.0371C15.3258 15.2102 15.091 15.3075 14.8462 15.3075C14.6014 15.3075 14.3666 15.2102 14.1935 15.0371C14.0203 14.864 13.9231 14.6292 13.9231 14.3844C13.9231 14.1396 14.0203 13.9048 14.1935 13.7317C14.3666 13.5586 14.6014 13.4613 14.8462 13.4613C15.091 13.4613 15.3258 13.5586 15.4989 13.7317C15.672 13.9048 15.7692 14.1396 15.7692 14.3844ZM15.7692 10.6921C15.7692 10.9369 15.672 11.1717 15.4989 11.3448C15.3258 11.5179 15.091 11.6152 14.8462 11.6152C14.6014 11.6152 14.3666 11.5179 14.1935 11.3448C14.0203 11.1717 13.9231 10.9369 13.9231 10.6921C13.9231 10.4473 14.0203 10.2125 14.1935 10.0394C14.3666 9.8663 14.6014 9.76904 14.8462 9.76904C15.091 9.76904 15.3258 9.8663 15.4989 10.0394C15.672 10.2125 15.7692 10.4473 15.7692 10.6921ZM11.1539 14.3844C11.1539 14.6292 11.0566 14.864 10.8835 15.0371C10.7104 15.2102 10.4756 15.3075 10.2308 15.3075C9.986 15.3075 9.75121 15.2102 9.5781 15.0371C9.40499 14.864 9.30774 14.6292 9.30774 14.3844C9.30774 14.1396 9.40499 13.9048 9.5781 13.7317C9.75121 13.5586 9.986 13.4613 10.2308 13.4613C10.4756 13.4613 10.7104 13.5586 10.8835 13.7317C11.0566 13.9048 11.1539 14.1396 11.1539 14.3844ZM11.1539 10.6921C11.1539 10.9369 11.0566 11.1717 10.8835 11.3448C10.7104 11.5179 10.4756 11.6152 10.2308 11.6152C9.986 11.6152 9.75121 11.5179 9.5781 11.3448C9.40499 11.1717 9.30774 10.9369 9.30774 10.6921C9.30774 10.4473 9.40499 10.2125 9.5781 10.0394C9.75121 9.8663 9.986 9.76904 10.2308 9.76904C10.4756 9.76904 10.7104 9.8663 10.8835 10.0394C11.0566 10.2125 11.1539 10.4473 11.1539 10.6921ZM6.53853 14.3844C6.53853 14.6292 6.44127 14.864 6.26816 15.0371C6.09505 15.2102 5.86027 15.3075 5.61545 15.3075C5.37064 15.3075 5.13585 15.2102 4.96274 15.0371C4.78963 14.864 4.69238 14.6292 4.69238 14.3844C4.69238 14.1396 4.78963 13.9048 4.96274 13.7317C5.13585 13.5586 5.37064 13.4613 5.61545 13.4613C5.86027 13.4613 6.09505 13.5586 6.26816 13.7317C6.44127 13.9048 6.53853 14.1396 6.53853 14.3844ZM6.53853 10.6921C6.53853 10.9369 6.44127 11.1717 6.26816 11.3448C6.09505 11.5179 5.86027 11.6152 5.61545 11.6152C5.37064 11.6152 5.13585 11.5179 4.96274 11.3448C4.78963 11.1717 4.69238 10.9369 4.69238 10.6921C4.69238 10.4473 4.78963 10.2125 4.96274 10.0394C5.13585 9.8663 5.37064 9.76904 5.61545 9.76904C5.86027 9.76904 6.09505 9.8663 6.26816 10.0394C6.44127 10.2125 6.53853 10.4473 6.53853 10.6921Z"
                                    fill="#838181" />
                            </g>
                            <defs>
                                <clipPath id="clip0_434_1084">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p>
                            @php
                                use Carbon\Carbon;
                                $cleanUpDate = Carbon::parse($activity->cleanUpDate)->format('d M Y');
                            @endphp
                            {{ $cleanUpDate }}
                        </p>
                    </div>
                    <div class="card-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path
                                d="M10.7714 4.85737C10.7714 4.65277 10.6901 4.45655 10.5454 4.31188C10.4008 4.16721 10.2045 4.08594 9.99994 4.08594C9.79535 4.08594 9.59913 4.16721 9.45446 4.31188C9.30979 4.45655 9.22852 4.65277 9.22852 4.85737V10.0002C9.22846 10.131 9.26166 10.2597 9.32499 10.3741C9.38833 10.4885 9.47972 10.585 9.59057 10.6544L12.6763 12.583C12.8498 12.6915 13.0593 12.7267 13.2588 12.6808C13.3575 12.6581 13.4508 12.6161 13.5334 12.5573C13.6159 12.4986 13.6861 12.4241 13.7398 12.3382C13.7936 12.2523 13.8299 12.1566 13.8467 12.0567C13.8635 11.9567 13.8604 11.8545 13.8377 11.7557C13.815 11.6569 13.773 11.5636 13.7142 11.4811C13.6554 11.3985 13.5809 11.3284 13.495 11.2746L10.7714 9.57234V4.85737Z"
                                fill="#838181" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 1C7.61305 1 5.32387 1.94821 3.63604 3.63604C1.94821 5.32387 1 7.61305 1 10C1 12.3869 1.94821 14.6761 3.63604 16.364C5.32387 18.0518 7.61305 19 10 19C12.3869 19 14.6761 18.0518 16.364 16.364C18.0518 14.6761 19 12.3869 19 10C19 7.61305 18.0518 5.32387 16.364 3.63604C14.6761 1.94821 12.3869 1 10 1ZM2.54286 10C2.54286 9.02071 2.73574 8.05102 3.1105 7.14628C3.48525 6.24153 4.03454 5.41946 4.727 4.727C5.41946 4.03454 6.24153 3.48525 7.14628 3.1105C8.05102 2.73574 9.02071 2.54286 10 2.54286C10.9793 2.54286 11.949 2.73574 12.8537 3.1105C13.7585 3.48525 14.5805 4.03454 15.273 4.727C15.9655 5.41946 16.5147 6.24153 16.8895 7.14628C17.2643 8.05102 17.4571 9.02071 17.4571 10C17.4571 11.9778 16.6715 13.8745 15.273 15.273C13.8745 16.6715 11.9778 17.4571 10 17.4571C8.02224 17.4571 6.12549 16.6715 4.727 15.273C3.32852 13.8745 2.54286 11.9778 2.54286 10Z"
                                fill="#838181" />
                        </svg>
                        <p>{{ substr($activity->startTime, 0, 5) }} - {{ substr($activity->endTime, 0, 5) }} WIB</p>
                    </div>
                </div>
                <div class="activity-content-detail-column">
                    <div class="card-row">
                        <div class="colored-dot"></div>
                        <p class="colored-dot-text">Aktivitas sudah selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('public.fasilitator.finalizeAttendance.tabbar.attendanceVerification')
        <table>
            <thead>
                <tr>
                    <th>Gambar Profil</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>Penentuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sukarelawanActivityDetails as $sad)
                    <tr>
                        <td>
                            @if ($sad->sukarelawan->profileImageUrl !== null)
                                <img src="{{ asset('storage/images/' . $sad->sukarelawan->profileImageUrl) }}"
                                    alt="{{ $sad->sukarelawan->user->name }}" class="img-fluid img-square-small">
                            @else
                                <img src="{{ asset('images/Fasilitator/logoImages/default.png') }}"
                                    alt="{{ $sad->sukarelawan->user->name }}" class="img-fluid img-square-small">
                            @endif
                        </td>
                        <td>{{ $sad->sukarelawan->user->name }}</td>
                        <td>{{ $sad->sukarelawan->gender }}</td>
                        <td>{{ $sad->sukarelawan->user->email }}</td>
                        <td>{{ $sad->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <form id="verifyForm" action="/verify/joinedSukarelawanAttendance/{{ $sad->id }}"
                                method="post">
                                @method('patch')
                                @csrf
                                <input type="hidden" name="activitySlug" value={{ $sad->activity->slug }}>
                                <button type="submit" class="approve-button">
                                    <span class="checkmark">&#10003;</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
