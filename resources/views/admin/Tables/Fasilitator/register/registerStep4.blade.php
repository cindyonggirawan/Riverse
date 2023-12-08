@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register-fasilitator.css') }}" />
@endsection

@section('content')
    <div style="height: 1560px;"></div>
    <div class="row">
        <!-- Form -->
        <form action="{{ route('fasilitator.store', ['step' => 4]) }}" method="post" class="register-container"
            id="register-container-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentStep" id="currentStep" value="{{ $currentStep }}">
            <!-- Card Body -->
            <div class="register-content" id="register-content-4">
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
                    <div class="tab-unselected">
                        <a href="/register/sukarelawan" class="tab-link">Sukarelawan</a>
                    </div>
                    <div class="tab-selected">
                        <a href="/register/fasilitator" class="tab-link">Fasilitator</a>
                    </div>
                </nav>
                <div class="form-steps">
                    <a href="/register/fasilitator">
                        <div class="circle">
                            1
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 >= 1 ? 'filled' : '' }}"></div>
                    <a href="/register/fasilitator/2">
                        <div class="circle">
                            2
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 >= 2 ? 'filled' : '' }}"></div>
                    <a href="/register/fasilitator/3">
                        <div class="circle">
                            3
                        </div>
                    </a>
                    <div class="line {{ $currentStep - 1 >= 3 ? 'filled' : '' }}"></div>
                    <div class="circle {{ $currentStep == 4 ? 'filled' : '' }}">
                        4
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
                    Pratinjau Data Fasilitator
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Nama Lengkap
                    </div>
                    <div class="form-content">
                        {{ Session::get('step2Data.name') }}
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Tipe
                    </div>
                    <div class="form-content">
                        @php
                            $fasilitatorTypeName = App\Models\FasilitatorType::find(Session::get('step2Data.fasilitatorTypeId'))->name;
                        @endphp
                        {{ $fasilitatorTypeName }}
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Deskripsi
                    </div>
                    <div class="form-content">
                        {{ Session::get('step2Data.description') }}
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Logo
                    </div>
                    <div class="form-content">
                        <div class="step3-image-preview">
                            <div class="image-preview" id="imagePreview"
                                @if (Session::has('step2Data.logoImageUrl')) @else hidden @endif>
                                @if (Session::has('step2Data.logoImageUrl'))
                                    <img id="previewImage"
                                        src="{{ asset('storage/' . Session::get('step2Data.logoImageUrl')) ?? '' }}"
                                        alt="Image Preview" />
                                @else
                                    <img id="previewImage" src="" alt="Image Preview" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="form-header">
                    Pratinjau Kontak Fasilitator
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Alamat
                    </div>
                    <div class="form-content">
                        {{ Session::get('step3Data.address') }}
                    </div>
                </div>
                <div class="form-text">
                    <div class="form-subheadline">
                        Nomor Telepon
                    </div>
                    <div class="form-content">
                        +62 {{ Session::get('step3Data.phoneNumber') }}
                    </div>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="purple-outline-btn-long">Daftar</button>
                    <a href="/register/fasilitator/3">
                        Sebelumnya
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
        </form>
        <!-- /.form -->
        <div class="register-image"
            style="background-image: url('{{ asset('/images/Register/register-fs-done.png') }}'); background-repeat: no-repeat;">
        </div>
    </div>
@endsection
