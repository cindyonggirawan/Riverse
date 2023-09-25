@extends('layout.index')

@section('title', 'Register as a Sukarelawan')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-5">
            @if (session()->has('registrationError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('registrationError') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <main class="form-registration w-100 m-auto">
                <h1 class="h3 mb-3 fw-normal text-center">Sukarelawan Registration Form</h1>
                <form action="/register/sukarelawan" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                        <label for="email" class="fw-bold" >Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password"
                            class="form-control rounded-bottom @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" required>
                        <label for="password" class="fw-bold">Password</label>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password_confirmation"
                            class="form-control rounded-bottom @error('password_confirmation') is-invalid @enderror" id="confirmpassword"
                            placeholder="Confirm Password" required>
                        <label for="confirmpassword" class="fw-bold">Confirm Password</label>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" name="name"
                            class="form-control rounded-top @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" required value="{{ old('name') }}">
                        <label for="name" class="fw-bold">Name</label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4 mt-3">
                        <p class="fw-bold" >Gender: </p>
                        <label for="male">Male</label>
                        <input type="radio" id="male" name="gender_id" value="male">

                        <label for="female">Female</label>
                        <input type="radio" id="female" name="gender_id" value="female">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="dateOfBirth">Date of Birth</label>
                        <input type="date" name="dateOfBirth" id="dateOfBirth" class="form-control" required>
                    </div>

                    <div class="mb-3 mt-6">
                        <label class="form-label fw-bold" for="flPictureImage">Display Picture</label>
                        <input class="form-control" id="flPictureImage" name="display_picture_link" type="file">
                        @error('display_picture_link')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <img class="w-25 ratio ratio-1x1 mt-3" id="picturePreview" src='' alt=""
                            style="aspect-ratio: 1; object-fit: cover;">
                    </div>

                    <div class="mb-3 mt-6">
                        <label class="form-label fw-bold" for="flKtpImage">National Identity Card Picture</label>
                        <input class="form-control" id="flKtpImage" name="ktp_picture_link" type="file">
                        @error('ktp_picture_link')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <img class="w-25 ratio ratio-1x1 mt-3" id="ktpPreview" src='' alt=""
                            style="aspect-ratio: 1; object-fit: cover;">
                    </div>


                    <div class="form-floating">
                        <input type="text" name="nik"
                            class="form-control rounded-top @error('nik') is-invalid @enderror" id="nik"
                            placeholder="National Identity Number" required value="{{ old('nik') }}">
                        <label for="nik" class="fw-bold">National Identity Number</label>
                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Register</button>

                </form>

                <small class="d-block text-center mt-3">Already Registered?<a href="/login">Login</a></small>
            </main>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        const pictureImageInp = document.querySelector("#flPictureImage");
        const pictureImageEl = document.querySelector("#picturePreview");

        const ktpImageInp = document.querySelector("#flKtpImage");
        const ktpImageEl = document.querySelector("#ktpPreview")

        pictureImageInp.onchange = (ev) => {
            const [file] = pictureImageInp.files;
            if (file) {
                pictureImageEl.src = URL.createObjectURL(file);
            }
        };

        ktpImageInp.onchange = (ev) => {
            const [file] = ktpImageInp.files;
            if (file) {
                ktpImageEl.src = URL.createObjectURL(file);
            }
        };
    </script>
@endpush
