@extends('Master.layout')
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/datedropper.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/timedropper.min.css') }}">
<style>
    .dd-w .dd-icon-check:before {
        line-height: 3;
    }

    .dd-w .dd-icon-right:before {
        line-height: 3;
    }

    .dd-w .dd-icon-left:before {
        line-height: 3;
    }
</style>
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="bordered-layout-colored-controls">Add a New Employee</h4>
            </div>
            <div class="card-content collpase show">
                <div class="card-body">
                    <form class="form form-horizontal form-bordered" action="{{ route('update.user') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h4 class="form-section"><i class="la la-eye"></i> User Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control" for="fullname">Full Name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="fullname" class="form-control border-primary"
                                                placeholder="Full Name" name="fullname" value="{{ $user->fullname ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('fullname')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control" for="username">User Name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="username" class="form-control border-primary"
                                                placeholder="User Name" name="username" value="{{ $user->username ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('username')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row last mx-auto">
                                        <label class="col-md-3 label-control" for="password">Password</label>
                                        <div class="col-md-9">
                                            <input type="password" id="password" class="form-control border-primary"
                                                placeholder="Password" name="password">
                                            <div class="help-block font-small-3">
                                                @error('password')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row last mx-auto">
                                        <label class="col-md-3 label-control" for="password_confirmation">Confirm
                                            Password</label>
                                        <div class="col-md-9">
                                            <input type="password" id="password_confirmation"
                                                class="form-control border-primary" placeholder="Confirm Password"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-section"><i class="ft-mail"></i> Employee Info</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control" for="userinput5">Email</label>
                                        <div class="col-md-9">
                                            <input class="form-control border-primary" type="email" placeholder="Email"
                                                name="email" id="email" value="{{ $user->email ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('email')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control">Phone Number</label>
                                        <div class="col-md-9">
                                            <input class="form-control border-primary" type="text"
                                                placeholder="Contact Number" name="phone" id="phone" value="{{ $user->phone ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('phone')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control" for="timesheetinput3">Join
                                            Date</label>
                                        <div class="col-md-9">

                                            <input type="text" class="form-control border-primary" id="animate"
                                                placeholder="Join Date" name="time_user" value="{{ $user->time_user ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('date')
                                                {{ $message }}
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row mx-auto">
                                        <label class="col-md-3 label-control" for="working_hrs">Working Hours</label>
                                        <div class="col-md-9">
                                            <input class="form-control border-primary" type="number"
                                                placeholder="Number of Hours" name="working_hrs" id="working_hrs" value="{{ $user->working_hrs ?? '' }}">
                                            <div class="help-block font-small-3">
                                                @error('working_hrs')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row last mx-auto">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Upload Employee Image</h4>
                                            </div>
                                            <div class="card-block">
                                                <div class="card-body">
                                                    <fieldset class="form-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="inputGroupFile02" name="image">
                                                            <label class="custom-file-label" for="inputGroupFile02"
                                                                aria-describedby="inputGroupFileAddon02">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="permissions" value="0">
                        <div class="form-actions text-right">
                            <button type="button" class="btn btn-warning mr-1">
                                <i class="ft-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-check-square-o"></i> Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/public/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/datedropper.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/timedropper.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/js/scripts/extensions/date-time-dropper.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/js/scripts/forms/custom-file-input.min.js') }}"></script>
@endsection