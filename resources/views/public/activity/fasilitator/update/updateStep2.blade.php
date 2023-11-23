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
                <div class="line filled"></div>
                <div class="circle filled">
                    2
                </div>
                <div class="line"></div>
                <div class="circle">
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
                        <label for="sukarelawanJobName">Nama Pekerjaan</label>
                        @error('sukarelawanJobName')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="sukarelawanJobName" id="sukarelawanJobName"
                            placeholder="Maksimal 50 Karakter"
                            value="{{ Session::get('step2DataUpdate.sukarelawanJobName') ?? $activity->sukarelawanJobName }}">


                        <label for="sukarelawanJobDetail">Tugas Sukarelawan</label>
                        @error('sukarelawanJobDetail')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <textarea class="lg" name="sukarelawanJobDetail" id="sukarelawanJobDetail" placeholder="Jelaskan tugas relawan">{{ Session::get('step2DataUpdate')['sukarelawanJobDetail'] ?? $activity->sukarelawanJobDetail }}</textarea>

                        <label for="sukarelawanCriteria">Kriteria Sukarelawan</label>
                        @error('sukarelawanCriteria')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <textarea class="lg" name="sukarelawanCriteria" id="sukarelawanCriteria" placeholder="Batasi dengan ';'"
                            rows="4">{{ Session::get('step2DataUpdate')['sukarelawanCriteria'] ?? $activity->sukarelawanCriteria }}</textarea>

                        <label for="minimumNumOfSukarelawan">Jumlah Sukarelawan</label>
                        @error('minimumNumOfSukarelawan')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="number-input">
                            <button type="button" onclick="decrementValue()" class="decrement">-</button>
                            <input type="number" name="minimumNumOfSukarelawan" id="minimumNumOfSukarelawan"
                                value="{{ Session::get('step2DataUpdate.minimumNumOfSukarelawan') ?? $activity->minimumNumOfSukarelawan }}">
                            <button type="button" onclick="incrementValue()" class="increment">+</button>
                        </div>


                        <label for="sukarelawanEquipment">Perlengkapan Sukarelawan</label>
                        @error('sukarelawanEquipment')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <textarea class="lg" name="sukarelawanEquipment" id="sukarelawanEquipment" placeholder="Batasi dengan ';'"
                            rows="4">{{ Session::get('step2DataUpdate')['sukarelawanEquipment'] ?? $activity->sukarelawanEquipment }}</textarea>
                    </div>
                </div>

                <div class="form-card-container">
                    <div class="form-card">
                        <div class="form-header">
                            Alat Komunikasi
                        </div>
                        <label for="groupChatUrl">Group Chat</label>
                        @error('groupChatUrl')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="groupChatUrl" id="groupChatUrl" placeholder="Tautan Whatsapp/Line"
                            value="{{ Session::get('step2DataUpdate')['groupChatUrl'] ?? $activity->groupChatUrl }}">
                    </div>
                </div>

                <button type="submit" class="btn-fill" id="nextStepButton" name="nextStepButton">
                    Lanjut
                </button>
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