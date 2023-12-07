@extends('layout.index')


@section('css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection


@section('content')
    <div class="col">
        <div class="register-col">
            <h1>Ayo Kontribusi ke Pembersihan Sungai di Indonesia</h1>
            <div class="choose-register">
                <a href="register/sukarelawan" class="register-option">
                    <p>Daftar sebagai</p>
                    <h2>Sukarelawan</h2>
                </a>

                <a href="register/fasilitator" class="register-option right">
                    <p>Daftar sebagai</p>
                    <h2>Fasilitator</h2>
                </a>
            </div>

            <span>
                Sudah punya akun?
                <a href="/login"> Login</a>
            </span>


        </div>
        <div class="register-img">
            <img src="{{ asset('images/Register/register-illustration.png') }}" alt="">

        </div>

    </div>
@endsection
