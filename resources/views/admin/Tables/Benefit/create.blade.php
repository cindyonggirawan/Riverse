@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/benefits/create" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
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
                            <label for="levelId" class="col-sm-4 col-form-label required">Level</label>
                            <div class="col-sm-8">
                                <select name="levelId" id="levelId"
                                    class="form-control select2bs4 @error('levelId') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    @foreach ($levels as $level)
                                        @if (old('levelId') == $level->id)
                                            <option value="{{ $level->id }}" selected>
                                                {{ $level->name }}
                                            </option>
                                        @else
                                            <option value="{{ $level->id }}">
                                                {{ $level->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('levelId')
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

                        <div class="form-group row">
                            <label for="couponCode" class="col-sm-4 col-form-label required">Coupon Code</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-ticket-alt px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="couponCode" id="couponCode"
                                    class="form-control @error('couponCode') is-invalid @enderror" placeholder="Coupon Code"
                                    required value="{{ old('couponCode') }}">
                            </div>
                            @error('couponCode')
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
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
@endsection
