@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/register/fasilitator" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label required">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email" required
                                    value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label required">Password</label>
                            <div class="input-group col-sm-8">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                <div class="input-group-append">
                                    <button id="toggle_password" class="btn btn-default" type="button">
                                        <i id="password_eye_icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-4 col-form-label required">Password
                                Confirmation</label>
                            <div class="input-group col-sm-8">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Password Confirmation" required>
                                <div class="input-group-append">
                                    <button id="toggle_password_confirmation" class="btn btn-default" type="button">
                                        <i id="password_confirmation_eye_icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label required">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" required
                                    value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="fasilitatorTypeId" class="col-sm-4 col-form-label required">Fasilitator Type</label>
                            <div class="col-sm-8">
                                <select name="fasilitatorTypeId" id="fasilitatorTypeId"
                                    class="form-control select2bs4 @error('fasilitatorTypeId') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    @foreach ($fasilitatorTypes as $fasilitatorType)
                                        @if (old('fasilitatorTypeId') == $fasilitatorType->id)
                                            <option value="{{ $fasilitatorType->id }}" selected>
                                                {{ $fasilitatorType->name }}
                                            </option>
                                        @else
                                            <option value="{{ $fasilitatorType->id }}">
                                                {{ $fasilitatorType->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('fasilitatorTypeId')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label required">Description</label>
                            <div class="col-sm-8">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Description" rows="3" style="resize: none;" required>{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="address" class="col-sm-4 col-form-label required">Address</label>
                            <div class="col-sm-8">
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Address" rows="3" style="resize: none;" required>{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="phoneNumber" class="col-sm-4 col-form-label required">Phone Number</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <b>+62</b>
                                    </div>
                                </div>
                                <input type="text" name="phoneNumber" id="phoneNumber"
                                    class="form-control @error('phoneNumber') is-invalid @enderror"
                                    placeholder="Phone Number" required value="{{ old('phoneNumber') }}">
                            </div>
                            @error('phoneNumber')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="logoImage_link" class="col-sm-4 col-form-label required">>Logo Image</label>
                            <div class="input-group col-sm-8">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input-2 @error('logoImage_link') is-invalid @enderror"
                                        name="logoImage_link" id="logoImage_link"
                                        accept="image/*" onchange="previewImage2()" required>
                                    <label class="custom-file-label" for="logoImage_link">Choose</label>
                                </div>
                            </div>
                            <img class="col-sm-4 offset-sm-4 img-fluid img-preview-2"></img>
                            @error('logoImage_link')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="text-center"><a href="/login">I already have an account</a></div>
                    </div>
                    <!-- /.card-body -->
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">
                            <i class="fas fa-angle-left">
                            </i>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Register</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const logoImageInp = document.querySelector("#flLogoImage");
        const logoImageEl = document.querySelector("#logoPreview");

        logoImageInp.onchange = (ev) => {
            const [file] = logoImageInp.files;
            if (file) {
                logoImageEl.src = URL.createObjectURL(file);
            }
        };

    </script>
@endpush

