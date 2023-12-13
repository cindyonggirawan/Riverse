@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/sukarelawan.css') }}" />
@endsection




@section('content')
    <div class="change-password">
        <form action="{{ route('password.update.change', ['user' => $user->slug]) }}" method="POST" action="patchlink">
            @method('patch')

            <div class="sukarelawan-form-col">
                <div class="sukarelawan-card-container">
                    <div class="sukarelawan-card-content full">
                        <h1>Ganti Password</h1>
                        <h2>Masukkan password lama dan baru Anda</h2>
                        <br>

                        <label for="oldPassword">Password Lama</label>
                        <input type="password" name="oldPassword" id="">
                        @error('password')
                            <p class="merah error-msg">{{ $message }}</p>
                        @enderror
                        <br>
                        <label for="newPassword">Password Baru</label>
                        <input type="password" name="newPassword" id="">
                        @error('newPassword')
                            <p class="merah error-msg">{{ $message }}</p>
                        @enderror
                        <label for="newPassword_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="newPassword_confirmation" id="">
                        @error('newPassword_confirmation')
                            <p class="merah error-msg">{{ $message }}</p>
                        @enderror

                        <div class="center-wrapper">
                            <button type="submit" class="btn-fill full">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="change-password-img">
            <img src="{{ asset('images/password-illustration.png') }}" alt="">
        </div>


    </div>
@endsection
