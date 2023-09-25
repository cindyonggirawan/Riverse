@extends('layout.index')

@section('title', 'Register as a Fasilitator')
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
                <h1 class="h3 mb-3 fw-normal text-center">Fasilitator Registration Form</h1>
                <form action="/register/fasilitator" method="post" enctype="multipart/form-data">
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
                            class="form-control rounded-top @error('name') is-invalid @enderror" id="fullname"
                            placeholder="Name" required value="{{ old('name') }}">
                        <label for="name" class="fw-bold">Name</label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="type" class="fw-bold">Tipe:
                            <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" >
                                <option value="Tipe 1">Tipe 1</option>
                                <option value="Tipe 2">Tipe 2</option>
                            </select>
                        </label>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" name="description"
                            class="form-control rounded-top @error('description') is-invalid @enderror" id="description"
                            placeholder="Description" required value="{{ old('description') }}">
                        <label for="description" class="fw-bold">Description</label>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 mt-6">
                        <label class="form-label fw-bold" for="flImage">Display Picture</label>
                        <input class="form-control" id="flImage" name="display_picture_link" type="file">
                        @error('display_picture_link')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <img class="w-25 ratio ratio-1x1 mt-3" id="preview" src='' alt=""
                            style="aspect-ratio: 1; object-fit: cover;">
                    </div>

                    <div class="form-floating">
                        <input type="tel" name="phoneNumber"
                            class="form-control rounded-top @error('phoneNumber') is-invalid @enderror" id="phoneNumber"
                            placeholder="Phone Number" required value="{{ old('phoneNumber') }}">
                        <label for="phoneNumber" class="fw-bold">Phone Number</label>
                        @error('phoneNumber')
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
        const imageInp = document.querySelector("#flImage");
        const imgEl = document.querySelector("#preview");

        imageInp.onchange = (ev) => {
            const [file] = imageInp.files;
            if (file) {
                imgEl.src = URL.createObjectURL(file);
            }
        };
    </script>
@endpush
