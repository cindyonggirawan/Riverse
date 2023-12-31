@extends('layout.index')

@section('css')
    {{-- @include('layout.useBootstrap') --}}
    <link rel="stylesheet" href="{{ asset('/css/leaderboard.css') }}" />
@endsection

@section('content')

    <h1>{{ $title }}</h1>

    <div class="ld-container">
        <div class="leaderboard-top-container">
            @if ($title != 'Empty Leaderboard')
                <div class="leaderboard-top-content-container">
                    <div class="rank-container rank-2"
                        style="background-image: url('{{ asset('images/Leaderboard/rank-2-background.png') }}')">
                        @if (!empty($sortedSukarelawans) && count($sortedSukarelawans) > 1)
                            <div class="profpic lg">
                                @if ($sortedSukarelawans[1]->profileImageUrl !== null)
                                    <img src="{{ asset('storage/images/' . $sortedSukarelawans[1]->profileImageUrl) }}"
                                        class="top-3-profile-picture" alt="">
                                @else
                                    <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                        class="top-3-profile-picture" alt="">
                                @endif
                            </div>
                            <h4 class="rank-header">{{ $sortedSukarelawans[1]->user->name }}</h4>
                            <img src="{{ asset('images/Leaderboard/ranking-trophy.png') }}" alt="trophy-image"
                                class="ranking-trophy-image-icon">
                            <h5 class="mengikuti">Mengikuti {{ $activityCount[1] }} aktivitas</h5>
                            <div class="flex-row-container">
                                <img src="{{ asset('images/Leaderboard/star-exp.png') }}" alt="star-image"
                                    class="star-image">
                                <h3 class="purple-text">{{ $sortedPoints[1] }} XP</h3>
                            </div>
                            <div class="adjust-rank-2-container-content"></div>
                        @endif

                    </div>
                    <div class="rank-container rank-1"
                        style="background-image: url('{{ asset('images/Leaderboard/rank-1-background.png') }}')">
                        @if (!empty($sortedSukarelawans) && count($sortedSukarelawans) > 0)
                            <img src="{{ asset('images/Leaderboard/crown.png') }}" alt="crown-image" class="crown-image">
                            <div class="profpic lg">
                                @if ($sortedSukarelawans[0]->profileImageUrl !== null)
                                    <img src="{{ asset('storage/images/' . $sortedSukarelawans[0]->profileImageUrl) }}"
                                        class="top-3-profile-picture" alt="">
                                @else
                                    <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                        class="top-3-profile-picture" alt="">
                                @endif
                            </div>
                            <h4 class="rank-header">{{ $sortedSukarelawans[0]->user->name }}</h4>
                            <img src="{{ asset('images/Leaderboard/ranking-trophy.png') }}" alt="trophy-image"
                                class="ranking-trophy-image-icon">
                            <h5 class="mengikuti">Mengikuti {{ $activityCount[0] }} aktivitas</h5>
                            <div class="flex-row-container">
                                <img src="{{ asset('images/Leaderboard/star-exp.png') }}" alt="star-image"
                                    class="star-image">
                                <h3 class="purple-text">{{ $sortedPoints[0] }} XP</h3>
                            </div>
                            <div class="adjust-rank-1-container-content"></div>
                        @endif
                    </div>
                    <div class="rank-container rank-3"
                        style="background-image: url('{{ asset('images/Leaderboard/rank-3-background.png') }}')">
                        @if (!empty($sortedSukarelawans) && count($sortedSukarelawans) > 2)
                            <div class="profpic lg">
                                @if ($sortedSukarelawans[2]->profileImageUrl !== null)
                                    <img src="{{ asset('storage/images/' . $sortedSukarelawans[2]->profileImageUrl) }}"
                                        class="top-3-profile-picture" alt="">
                                @else
                                    <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                        class="top-3-profile-picture" alt="">
                                @endif
                            </div>
                            <h4 class="rank-header">{{ $sortedSukarelawans[2]->user->name }}</h4>
                            <img src="{{ asset('images/Leaderboard/ranking-trophy.png') }}" alt="trophy-image"
                                class="ranking-trophy-image-icon">
                            <h5 class="mengikuti">Mengikuti {{ $activityCount[2] }} aktivitas</h5>
                            <div class="flex-row-container">
                                <img src="{{ asset('images/Leaderboard/star-exp.png') }}" alt="star-image"
                                    class="star-image">
                                <h3 class="purple-text">{{ $sortedPoints[2] }} XP</h3>
                            </div>
                        @endif
                    </div>
                </div>
                <img src="{{ asset('images/Leaderboard/leaderboard-background.png') }}" alt="leaderboard-background-image"
                    class="leaderboard-background-image">
                {{-- <div class="leaderboard-top-content-wrap-row-container">
                </div> --}}
            @endif
        </div>

        @auth
            @if ($title != 'Empty Leaderboard' && auth()->user()->role->name == 'Sukarelawan' && $userRank != 0)
                <div class="user-rank-container">
                    <p>Anda memperoleh </p>
                    <img src="{{ asset('images/Leaderboard/star-exp.png') }}" alt="star-image" class="star-image">
                    <p class="purple-text">{{ $userPoints }} XP </p>
                    <p>hari ini dan memiliki peringkat </p>
                    <p class="purple-text">{{ $userRank }}</p>
                    <p> dari </p>
                    <p class="purple-text">{{ $userCount }} sukarelawan</p>
                </div>
            @endif
        @endauth

        <div class="custom-table-responsive">
            @if ($title != 'Empty Leaderboard')
                <div class="header-custom-container-row">
                    <div class="rank-column header-text">
                        <p>Peringkat</p>
                    </div>
                    <div class="name-column header-text">
                        <p>Nama Lengkap</p>
                    </div>
                    <div class="level-column-header header-text">
                        <p>Level</p>
                    </div>
                    <div class="activity-qty-column header-text">
                        <p>Aktivitas</p>
                    </div>
                    <div class="exp-column header-text">
                        <p>XP</p>
                    </div>
                </div>
                @for ($i = 3; $i < count($sortedSukarelawans); $i++)
                    <div class="custom-container-row">
                        <div class="rank-column">
                            <img src="{{ asset('images/Leaderboard/ranking-trophy.png') }}" alt="trophy-image"
                                class="ranking-trophy-image">
                            <p>{{ $i + 1 }}</p>
                        </div>
                        <div class="name-column">
                            <div class="profpic">
                                @if ($sortedSukarelawans[$i]->profileImageUrl && $sortedSukarelawans[$i]->profileImageUrl != '')
                                    <img src="{{ asset('storage/images/' . $sortedSukarelawans[$i]->profileImageUrl) }}"
                                        class="leaderboard-profile-picture" alt="">
                                @else
                                    <img src="{{ asset('images/Sukarelawan/profileImages/default.png') }}"
                                        class="leaderboard-profile-picture" alt="">
                                @endif
                            </div>

                            <p class="ml">{{ $sortedSukarelawans[$i]->user->name }}</p>
                        </div>
                        <div class="level-column">
                            <p>{{ $sortedSukarelawans[$i]->level->name }}</p>
                        </div>
                        <div class="activity-qty-column">
                            <p>{{ $activityCount[$i] }} aktivitas</p>
                        </div>
                        <div class="exp-column">
                            <img src="{{ asset('images/Leaderboard/star-exp.png') }}" alt="star-image"
                                class="star-image">
                            <p class="purple-text">{{ $sortedPoints[$i] }} XP</p>
                        </div>
                    </div>
                @endfor
            @else
                <img src="{{ asset('images/Leaderboard/empty-leaderboard-background.png') }}"
                    class="empty-leaderboard-background" alt="empty-leaderboard-background">
            @endif

        </div>
    </div>



@endsection


{{-- <div class="card-body">
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Email</th>
                <th>Level</th>
                <th>Jumlah Aktivitas Selesai</th>
                <th>Experience Point</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($sortedSukarelawans); $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $sortedSukarelawans[$i]->user->email }}</a></td>
                    <td>{{ $sortedSukarelawans[$i]->level->name }}</a></td>
                    <td>{{ $activityCount[$i] }} aktivitas</a></td>
                    <td>{{ $sortedPoints[$i] }} XP</td>
                </tr>
            @endfor
        </tbody>
    </table>

    @auth
        @if ($userRank != 0)
            <h1>Your rank #{{ $userRank }}</h1>
        @endif
    @endauth

</div> --}}
