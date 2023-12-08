@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection

@section('content')
    <div class="row">
        <!-- Form -->
        <form action="{{ route('sukarelawan.store', ['step' => 3]) }}" method="post" class="register-container"
            id="register-container-3" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <!-- Card Body -->
            <div class="register-content" id="register-content-3">
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="form-text-header">
                    <h1>Daftar</h1>
                    <div class="register-account-text">
                        <p>Sudah punya akun?</p>
                        <a href="/login">Masuk</a>
                    </div>
                </div>
                <nav class="row tab-menu">
                    <div class="tab-selected">
                        <a href="/register/sukarelawan" class="tab-link">Sukarelawan</a>
                    </div>
                    <div class="tab-unselected">
                        <a href="/register/fasilitator" class="tab-link">Fasilitator</a>
                    </div>
                </nav>
                <div class="form-steps">
                    <a href="/register/sukarelawan">
                        <div class="circle">
                            1
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 == 1 ? 'filled' : '' }}"></div>
                    <a href="/register/sukarelawan/2">
                        <div class="circle">
                            2
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 == 2 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 3 ? 'filled' : '' }}">
                        3
                    </div>
                </div>
                <div class="form-header">
                    Pratinjau Data Akun
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Email
                    </div>
                    <div class="form-content">
                        {{ Session::get('step1Data.email') }}
                    </div>
                </div>
                <div class="divider"></div>
                <div class="form-header">
                    Pratinjau Data Sukarelawan
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Nama Lengkap
                    </div>
                    <div class="form-content">
                        {{ Session::get('step2Data.name') }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-text-division">
                        <div class="form-subheadline">
                            Jenis Kelamin
                        </div>
                        <div class="form-content">
                            {{ Session::get('step2Data.gender') }}
                        </div>
                    </div>
                    <div class="form-text-division">
                        <div class="form-subheadline">
                            Tanggal Lahir
                        </div>
                        <div class="form-content">
                            @php
                                $date = Session::get('step2Data.dateOfBirth');
                                $formattedDate = date('d/m/Y', strtotime($date));
                            @endphp
                            {{ $formattedDate }}
                        </div>
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        NIK
                    </div>
                    <div class="form-content">
                        {{ Session::get('step2Data.nationalIdentityNumber') }}
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Kartu Tanda Penduduk (KTP)
                    </div>
                    <div class="form-content">
                        <div class="step3-image-preview">
                            <div class="image-preview" id="imagePreview"
                                @if (Session::has('step2Data.nationalIdentityCardImageUrl')) @else hidden @endif>
                                @if (Session::has('step2Data.nationalIdentityCardImageUrl'))
                                    <img id="previewImage"
                                        src="{{ asset('storage/' . Session::get('step2Data.nationalIdentityCardImageUrl')) ?? '' }}"
                                        alt="Image Preview" />
                                @else
                                    <img id="previewImage" src="" alt="Image Preview" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Daftar</button>
                    <a href="/register/sukarelawan/2">
                        Sebelumnya
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="register-image" style="background-image: url('{{ asset('/images/register-image.png') }}');">
        </div>
    </div>
@endsection
