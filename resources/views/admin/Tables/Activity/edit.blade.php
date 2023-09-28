@extends('admin.layouts.main')

@section('admin.information')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <!-- Form -->
                <form action="/activities/{{ $activity->slug }}" method="post" class="form-horizontal">
                    @method('patch')
                    @csrf
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label required">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" required
                                    value="{{ old('name', $activity->name) }}">
                            </div>
                            @error('name')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label required">Description</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="description" id="description" class="trix-content">
                                <trix-editor input="description"
                                    class="@error('description') is-invalid-in-editor @enderror" placeholder="Description"
                                    required>{!! old('description', $activity->description) !!}</trix-editor>
                            </div>
                            @error('description')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="registrationDeadlineDate" class="col-sm-4 col-form-label required">Registration
                                Deadline Date</label>
                            <div class="input-group col-sm-8 date" id="rdd" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#rdd" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="registrationDeadlineDate" id="registrationDeadlineDate"
                                    class="form-control datetimepicker-input @error('registrationDeadlineDate') is-invalid @enderror"
                                    data-target="#rdd" placeholder="DD/MM/YYYY" required
                                    value="{{ old('registrationDeadlineDate', date('d/m/Y', strtotime(str_replace('-', '/', $activity->registrationDeadlineDate)))) }}">
                            </div>
                            @error('registrationDeadlineDate')
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
                                        @if (old('verificationStatusId', $activity->verificationStatusId) == $verificationStatus->id)
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
                                    rows="3" style="resize: none;">{{ old('reasonForRejection', $activity->reasonForRejection) }}</textarea>
                            </div>
                            @error('reasonForRejection')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="cleanUpDate" class="col-sm-4 col-form-label required">Clean Up Date</label>
                            <div class="input-group col-sm-8 date" id="cud" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#cud" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="cleanUpDate" id="cleanUpDate"
                                    class="form-control datetimepicker-input @error('cleanUpDate') is-invalid @enderror"
                                    data-target="#cud" placeholder="DD/MM/YYYY" required
                                    value="{{ old('cleanUpDate', date('d/m/Y', strtotime(str_replace('-', '/', $activity->cleanUpDate)))) }}">
                            </div>
                            @error('cleanUpDate')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="startTime" class="col-sm-4 col-form-label required">Start Time</label>
                            <div class="input-group col-sm-8 date" id="st" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#st" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fas fa-clock px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="startTime" id="startTime"
                                    class="form-control @error('startTime')
                                    is-invalid
                                @enderror datetimepicker-input"
                                    data-target="#st" placeholder="HH:mm" required
                                    value="{{ old('startTime', date('H:i', strtotime($activity->startTime))) }}">
                            </div>
                            @error('startTime')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="endTime" class="col-sm-4 col-form-label required">End Time</label>
                            <div class="input-group col-sm-8 date" id="et" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#et" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fas fa-clock px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="endTime" id="endTime"
                                    class="form-control @error('endTime')
                                    is-invalid
                                @enderror datetimepicker-input"
                                    data-target="#et" placeholder="HH:mm" required
                                    value="{{ old('endTime', date('H:i', strtotime($activity->endTime))) }}">
                            </div>
                            @error('endTime')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="gatheringPointUrl" class="col-sm-4 col-form-label required">Gathering Point
                                Url</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-link px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="gatheringPointUrl" id="gatheringPointUrl"
                                    class="form-control @error('gatheringPointUrl') is-invalid @enderror"
                                    placeholder="Gathering Point Url" required
                                    value="{{ old('gatheringPointUrl', $activity->gatheringPointUrl) }}">
                            </div>
                            @error('gatheringPointUrl')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="sukarelawanJobName" class="col-sm-4 col-form-label required">Sukarelawan Job
                                Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="sukarelawanJobName" id="sukarelawanJobName"
                                    class="form-control @error('sukarelawanJobName') is-invalid @enderror"
                                    placeholder="Sukarelawan Job Name" required
                                    value="{{ old('sukarelawanJobName', $activity->sukarelawanJobName) }}">
                            </div>
                            @error('sukarelawanJobName')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="sukarelawanJobDetail" class="col-sm-4 col-form-label required">Sukarelawan Job
                                Detail</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="sukarelawanJobDetail" id="sukarelawanJobDetail"
                                    class="trix-content">
                                <trix-editor input="sukarelawanJobDetail"
                                    class="@error('sukarelawanJobDetail') is-invalid-in-editor @enderror"
                                    placeholder="Sukarelawan Job
                                    Detail"
                                    required>{!! old('sukarelawanJobDetail', $activity->sukarelawanJobDetail) !!}</trix-editor>
                            </div>
                            @error('sukarelawanJobDetail')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="sukarelawanCriteria" class="col-sm-4 col-form-label required">Sukarelawan
                                Criteria</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="sukarelawanCriteria" id="sukarelawanCriteria"
                                    class="trix-content">
                                <trix-editor input="sukarelawanCriteria"
                                    class="@error('sukarelawanCriteria') is-invalid-in-editor @enderror"
                                    placeholder="Sukarelawan
                                    Criteria"
                                    required>{!! old('sukarelawanCriteria', $activity->sukarelawanCriteria) !!}</trix-editor>
                            </div>
                            @error('sukarelawanCriteria')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="minimumNumOfSukarelawan" class="col-sm-4 col-form-label required">Minimum Num Of
                                Sukarelawan</label>
                            <div class="col-sm-8">
                                <input type="number" name="minimumNumOfSukarelawan" id="minimumNumOfSukarelawan"
                                    class="form-control @error('minimumNumOfSukarelawan') is-invalid @enderror"
                                    placeholder="Minimum Num Of Sukarelawan" required
                                    value="{{ old('minimumNumOfSukarelawan', $activity->minimumNumOfSukarelawan) }}">
                            </div>
                            @error('minimumNumOfSukarelawan')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="sukarelawanEquipment" class="col-sm-4 col-form-label required">Sukarelawan
                                Equipment</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="sukarelawanEquipment" id="sukarelawanEquipment"
                                    class="trix-content">
                                <trix-editor input="sukarelawanEquipment"
                                    class="@error('sukarelawanEquipment') is-invalid-in-editor @enderror"
                                    placeholder="Sukarelawan
                                    Equipment"
                                    required>{!! old('sukarelawanEquipment', $activity->sukarelawanEquipment) !!}</trix-editor>
                            </div>
                            @error('sukarelawanEquipment')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="groupChatUrl" class="col-sm-4 col-form-label required">Group Chat Url</label>
                            <div class="input-group col-sm-8">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-link px-1"></i>
                                    </div>
                                </div>
                                <input type="text" name="groupChatUrl" id="groupChatUrl"
                                    class="form-control @error('groupChatUrl') is-invalid @enderror"
                                    placeholder="Group Chat Url" required
                                    value="{{ old('groupChatUrl', $activity->groupChatUrl) }}">
                            </div>
                            @error('groupChatUrl')
                                <div class="col-sm-8 offset-sm-4 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <label for="experiencePointGiven" class="col-sm-4 col-form-label">Experience Point
                                Given</label>
                            <div class="col-sm-8">
                                <input type="number" name="experiencePointGiven" id="experiencePointGiven"
                                    class="form-control @error('experiencePointGiven') is-invalid @enderror"
                                    placeholder="Experience Point Given"
                                    value="{{ old('experiencePointGiven', $activity->experiencePointGiven) }}">
                            </div>
                            @error('experiencePointGiven')
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
