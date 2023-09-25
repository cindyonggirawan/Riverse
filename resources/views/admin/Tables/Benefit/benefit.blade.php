@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <!-- /.Card Body-->
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Id</dt>
                        <dd class="col-sm-8">{{ $benefit->id }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Level Id</dt>
                        <dd class="col-sm-8">{{ $benefit->levelId }}</dd>

                        <dt class="col-sm-4">Level</dt>
                        <dd class="col-sm-8">{{ $benefit->level->name }}</dd>

                        <hr class="col-sm-12">

                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $benefit->name }}</dd>

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $benefit->description }}</dd>

                        <dt class="col-sm-4">Coupon Code</dt>
                        <dd class="col-sm-8">{{ $benefit->couponCode }}</dd>

                        <dt class="col-sm-4">Banner Image Url</dt>
                        <dd class="col-sm-8">{{ $benefit->bannerImageUrl !== null ? $benefit->bannerImageUrl : '-' }}

                        <dt class="col-sm-4">Slug</dt>
                        <dd class="col-sm-8">{{ $benefit->slug }}</dd>

                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $benefit->created_at }}</dd>

                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $benefit->updated_at }}</dd>
                    </dl>
                </div>
                <!-- /.card-body -->
                <!-- Card Footer -->
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-default">
                        <i class="fas fa-angle-left">
                        </i>
                        Back
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
