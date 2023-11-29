@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/fasilitators/{{ $fasilitator->slug }}" method="post" class="form-horizontal"
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
                                    value="{{ old('email', $fasilitator->user->email) }}">
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
                                        @if (old('verificationStatusId', $fasilitator->verificationStatusId) == $verificationStatus->id)
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
                                    rows="3" style="resize: none;">{{ old('reasonForRejection', $fasilitator->reasonForRejection) }}</textarea>
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
                                    value="{{ old('name', $fasilitator->user->name) }}">
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
                                        @if (old('fasilitatorTypeId', $fasilitator->fasilitatorTypeId) == $fasilitatorType->id)
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
                                    placeholder="Description" rows="3" style="resize: none;" required>{{ old('description', $fasilitator->description) }}</textarea>
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
                                    placeholder="Address" rows="3" style="resize: none;" required>{{ old('address', $fasilitator->address) }}</textarea>
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
                                    placeholder="Phone Number" required
                                    value="{{ old('phoneNumber', $fasilitator->phoneNumber) }}">
                            </div>
                            @error('phoneNumber')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="logoImageUrl" class="col-sm-4 col-form-label required">Logo Image</label>
                            <input type="hidden" name="oldlogoImageUrl" id="oldlogoImageUrl"
                                value="{{ $fasilitator->logoImageUrl }}">
                            <div class="input-group col-sm-8">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('logoImageUrl') is-invalid @enderror"
                                        name="logoImageUrl" id="logoImageUrl" accept="image/*" onchange="previewImage()"
                                        required>
                                    <label class="custom-file-label" for="logoImageUrl">Choose</label>
                                </div>
                            </div>
                            @if ($fasilitator->logoImageUrl !== null)
                                <img src="{{ asset('storage/' . $fasilitator->logoImageUrl) }}"
                                    alt="{{ $fasilitator->user->name }}"
                                    class="col-sm-4 offset-sm-4 mt-3 img-fluid img-square-big img-preview">
                            @else
                                <img class="col-sm-4 offset-sm-4 img-fluid img-preview"></img>
                            @endif

                            @error('logoImageUrl')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
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
