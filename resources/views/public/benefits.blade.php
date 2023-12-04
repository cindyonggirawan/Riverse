@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/benefits.css') }}" />
@endsection

@php
    $levelGradientStyling = 'background: linear-gradient(180deg, #8C99C6 0%, #B8C4E1 100%);';
    $benefitImageName = 'default';
@endphp

@php
    // dd(auth()->user()->sukarelawan->level->name);
@endphp


@section('content')
    <h1>Keuntungan</h1>
    <div class="levels-grid">

        @foreach ($levels as $level)
            @php
                if ($level->name == 'Level 2') {
                    $levelGradientStyling = 'background: linear-gradient(180deg, #03CE96 0%, #49DFDE 100%);';
                } elseif ($level->name == 'Level 3') {
                    $levelGradientStyling = 'background: linear-gradient(180deg, #FEDB70 0%, #FD8C5E 100%);';
                } elseif ($level->name == 'Level 4') {
                    $levelGradientStyling = 'background: linear-gradient(180deg, #0279FE 0%, #01BFA0 100%);';
                } elseif ($level->name == 'Level 5') {
                    $levelGradientStyling = 'background: linear-gradient(180deg, #8A4EF5 0%, #B41FF7 100%);';
                } elseif ($level->name == 'Level 6') {
                    $levelGradientStyling = 'background: linear-gradient(180deg, #9449F6 0%, #FE5DB2 100%);';
                }
            @endphp

            <div class="level-container" style="{{ $levelGradientStyling }}">
                <div class="level-image">
                    @php
                        $imageLevelName = strtolower(str_replace(' ', '_', $level->name));
                    @endphp
                    <img src="{{ asset('images/Levels/' . $imageLevelName . '.png') }}" alt="Level Badge">
                </div>
                <div class="level-name">
                    <h1>{{ $level->name }}</h1>
                </div>
                @foreach ($level->benefits as $benefit)
                    @php
                        if (strpos($benefit->name, 'kopi') !== false) {
                            $benefitImageName = 'kopi';
                        }
                        if (strpos($benefit->name, 'kaos') !== false) {
                            $benefitImageName = 'kaos';
                        }
                        if (strpos($benefit->name, 'tumbler') !== false) {
                            $benefitImageName = 'tumbler';
                        }
                        if (strpos($benefit->name, 'kopi') !== false) {
                            $benefitImageName = 'totebag';
                        }
                    @endphp
                    <div class="benefit-card">
                        <div class="benefit-card-image">
                            <img src="{{ asset('images/Benefits/' . $benefitImageName . '.png') }}" alt="Level Badge">
                        </div>
                        <div class="benefit-card-content">
                            <h3>
                                {{ $benefit->name }}
                            </h3>
                            <p>
                                {{ Illuminate\Support\Str::limit($benefit->description, 100) }}
                            </p>

                            @php
                                $userLevelName = auth()->user()->sukarelawan->level->name;
                                // $userLevelName = 'Level 2';
                                if (auth()->user()->sukarelawan != null) {
                                    $comparisonResult = strcmp(preg_replace('/\D/', '', $userLevelName), preg_replace('/\D/', '', $benefit->level->name));
                                    // 0 --> equal
                                }
                            @endphp


                            @if (auth()->check() && auth()->user()->sukarelawan != null && $comparisonResult >= 0)
                                <div class="voucher-code">
                                    <p>{{ $benefit->couponCode }}</p>
                                </div>
                            @else
                                <div class="voucher-code danger">
                                    <p>Level Belum Cukup</p>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
