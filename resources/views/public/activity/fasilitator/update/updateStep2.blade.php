@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <div class="create-activity">
        <div class="top">
            <h1>Edit Aktivitas</h1>
            <div class="form-steps">
                <a href="/activities/{{ $activity->slug }}/edit/1">
                    <div class="circle">
                        1
                    </div>
                </a>
                <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                <div class="circle {{ $currentStep == 2 ? 'filled' : '' }}">
                    2
                </div>
                <div class="line {{ $currentStep - 1 >= 2 ? 'filled' : '' }}"></div>
                <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                    3
                </div>
            </div>
        </div>

        <form action="{{ route('activity.publicUpdate', ['activity' => $activity->slug, 'step' => 2]) }}" method="post"
            action="patchlink" class="create-activity-form" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="2">
            <div class="form-step-container">
                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Data Sukarelawan
                        </div>
                        <div class="form-text">
                            <label for="sukarelawanJobName" class="required">Nama Pekerjaan</label>
                            <div class="row">
                                <input type="text" name="sukarelawanJobName" id="sukarelawanJobName"
                                    class="input-text-long @error('sukarelawanJobName') is-invalid @enderror"
                                    placeholder="Maksimal 50 Karakter" required
                                    value="{{ Session::get('step2DataUpdate.sukarelawanJobName') ?? old('sukarelawanJobName', $activity->sukarelawanJobName) }}">
                            </div>
                            @error('sukarelawanJobName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-text">
                            <label for="sukarelawanJobDetail" class="required">Tugas Sukarelawan</label>
                            <div class="row">
                                <textarea name="sukarelawanJobDetail" id="sukarelawanJobDetail"
                                    class="input-text-long @error('sukarelawanJobDetail') is-invalid @enderror" placeholder="Jelaskan tugas relawan"
                                    rows="3" style="resize: none;" required>{{ Session::get('step2DataUpdate.sukarelawanJobDetail') ?? old('sukarelawanJobDetail', $activity->sukarelawanJobDetail) }}</textarea>
                            </div>
                            @error('sukarelawanJobDetail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-text">
                            <label for="sukarelawanCriteria" class="required">Kriteria Sukarelawan</label>
                            <div class="row">
                                <textarea name="sukarelawanCriteria" id="sukarelawanCriteria"
                                    class="input-text-long @error('sukarelawanCriteria') is-invalid @enderror" placeholder="Batasi dengan ;"
                                    rows="3" style="resize: none;" required>{{ Session::get('step2DataUpdate.sukarelawanCriteria') ?? old('sukarelawanCriteria', $activity->sukarelawanCriteria) }}</textarea>
                            </div>
                            @error('sukarelawanCriteria')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-text">
                            <label for="minimumNumOfSukarelawan" class="required">Jumlah Sukarelawan</label>
                            <div class="number-input">
                                <button type="button" onclick="decrementValue()" class="decrement">-</button>
                                <input type="number" name="minimumNumOfSukarelawan" id="minimumNumOfSukarelawan"
                                    value="{{ Session::get('step2DataUpdate.minimumNumOfSukarelawan') ?? (old('minimumNumOfSukarelawan', $activity->minimumNumOfSukarelawan) ?? 0) }}">
                                <button type="button" onclick="incrementValue()" class="increment">+</button>
                            </div>
                            @error('minimumNumOfSukarelawan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-text last">
                            <label for="sukarelawanEquipment" class="required">Perlengkapan Sukarelawan</label>
                            <div class="row">
                                <textarea name="sukarelawanEquipment" id="sukarelawanEquipment"
                                    class="input-text-long @error('sukarelawanEquipment') is-invalid @enderror" placeholder="Batasi dengan ;"
                                    rows="3" style="resize: none;" required>{{ Session::get('step2DataUpdate.sukarelawanEquipment') ?? old('sukarelawanEquipment', $activity->sukarelawanEquipment) }}</textarea>
                            </div>
                            @error('sukarelawanEquipment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Alat Komunikasi
                        </div>
                        <div class="form-text last">
                            <label for="groupChatUrl" class="required">Group Chat</label>
                            <div class="row">
                                <input type="text" name="groupChatUrl" id="groupChatUrl"
                                    class="input-text-long @error('groupChatUrl') is-invalid @enderror"
                                    placeholder="Tautan Whatsapp/Line" required
                                    value="{{ Session::get('step2DataUpdate.groupChatUrl') ?? old('groupChatUrl', $activity->groupChatUrl) }}">
                            </div>
                            @error('groupChatUrl')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn-fill" id="nextStepButton" name="nextStepButton">
                        Lanjut
                    </button>
                </div>
            </div>
        </form>

        <div class="goBack">
            <a href="/activities/{{ $activity->slug }}/edit/1">
                <button>Sebelumnya</button>
            </a>
        </div>
    </div>
    <script src="{{ asset('js/step2Form.js') }}"></script>
@endsection
