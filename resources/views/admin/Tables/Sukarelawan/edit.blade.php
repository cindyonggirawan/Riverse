@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/sukarelawans/{{ $sukarelawan->slug }}" method="post" class="form-horizontal"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label required">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email" required
                                    value="{{ old('email', $sukarelawan->user->email) }}">
                            </div>
                            @error('email')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="verificationStatusId" class="col-sm-4 col-form-label required">Verification
                                Status</label>
                            <div class="col-sm-8">
                                <select name="verificationStatusId" id="verificationStatusId"
                                    class="form-control select2bs4 @error('verificationStatusId') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    @foreach ($verificationStatuses as $verificationStatus)
                                        @if (old('verificationStatusId', $sukarelawan->verificationStatusId) == $verificationStatus->id)
                                            <option value="{{ $verificationStatus->id }}" selected>
                                                {{ $verificationStatus->name }}
                                            </option>
                                        @else
                                            <option value="{{ $verificationStatus->id }}">
                                                {{ $verificationStatus->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('verificationStatusId')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="reasonForRejection" class="col-sm-4 col-form-label">Reason For
                                Rejection</label>
                            <div class="col-sm-8">
                                <textarea name="reasonForRejection" id="reasonForRejection"
                                    class="form-control @error('reasonForRejection') is-invalid @enderror" placeholder="Reason For Rejection"
                                    rows="3" style="resize: none;">{{ old('reasonForRejection', $sukarelawan->reasonForRejection) }}</textarea>
                            </div>
                            @error('reasonForRejection')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label required">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" required
                                    value="{{ old('name', $sukarelawan->user->name) }}">
                            </div>
                            @error('name')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-sm-4 col-form-label required">Gender</label>
                            <div class="col-sm-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" id="laki-laki" value="Laki-laki"
                                        class="custom-control-input @error('gender') is-invalid @enderror" required
                                        {{ old('gender', $sukarelawan->gender) === 'Laki-laki' ? 'checked' : '' }}>
                                    <label for="laki-laki" class="custom-control-label">Laki-laki</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" id="perempuan" value="Perempuan"
                                        class="custom-control-input @error('gender') is-invalid @enderror" required
                                        {{ old('gender', $sukarelawan->gender) === 'Perempuan' ? 'checked' : '' }}>
                                    <label for="perempuan" class="custom-control-label">Perempuan</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="dateOfBirth" class="col-sm-4 col-form-label required">Date Of Birth</label>
                            <div class="input-group col-sm-8 date" id="dob" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#dob" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="dateOfBirth" id="dateOfBirth"
                                    class="form-control datetimepicker-input @error('dateOfBirth') is-invalid @enderror"
                                    data-target="#dob" placeholder="DD/MM/YYYY" required
                                    value="{{ old('dateOfBirth', date('d/m/Y', strtotime(str_replace('-', '/', $sukarelawan->dateOfBirth)))) }}">
                            </div>
                            @error('dateOfBirth')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="nationalIdentityNumber" class="col-sm-4 col-form-label required">National Identity
                                Number</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                                <input type="text" name="nationalIdentityNumber" id="nationalIdentityNumber"
                                    class="form-control @error('nationalIdentityNumber') is-invalid @enderror"
                                    placeholder="National Identity Number" required
                                    value="{{ old('nationalIdentityNumber', $sukarelawan->nationalIdentityNumber) }}">
                            </div>
                            @error('nationalIdentityNumber')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="flKtpImage" class="col-sm-4 col-form-label">National Identity Card Image</label>
                            <div class="col-sm-8">
                                <input type="file" name="nationalIdentityCardImage_link" id="flKtpImage"
                                    class="form-control" value="{{ old('nationalIdentityCardImage_link', $sukarelawan->nationalIdentityCardImageUrl) }}">
                            </div>
                            @error('nationalIdentityCardImage_link')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                            <img class="w-25 ratio ratio-1x1 mt-3" id="ktpPreview" src="{{ asset('storage/' . $sukarelawan->nationalIdentityCardImageUrl) }}" alt=""
                                style="aspect-ratio: 1; object-fit: cover;">
                        </div>

                        <div class="form-group row">
                            <label for="flPictureImage" class="col-sm-4 col-form-label">Profile Image</label>
                            <div class="col-sm-8">
                                <input type="file" name="profileImage_link" id="flPictureImage"
                                class="form-control" value="{{ old('profileImage_link', $sukarelawan->profileImageUrl) }}">
                            </div>
                            @error('profileImage_link')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                            <img class="w-25 ratio ratio-1x1 mt-3" id="picturePreview" src="{{ asset('storage/' . $sukarelawan->profileImageUrl) }}" alt=""
                                style="aspect-ratio: 1; object-fit: cover;">
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">
                            <i class="fas fa-angle-left">
                            </i>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
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
