@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/datedropper.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/timedropper.min.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="bordered-layout-icons">Edit Record</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content collpase show">
                <div class="card-body">
                    <form class="form form-horizontal form-bordered" method="POST"
                        action="{{ route('update.Urecord', ['id' => $record->id]) }}">
                        @csrf
                        <div class="form-body">
                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="name">Employee Name</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="name" class="form-control" placeholder="Employee Name"
                                            readonly="readonly" name="fullname" value="{{ $record->name_record }}">
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="date">Date</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="date" class="form-control" placeholder="Employee Name"
                                            readonly="readonly" name="date"
                                            value="{{ Carbon\Carbon::createFromTimestamp($record->login_time_record)->isoFormat('M/D/YY') }}">
                                        <div class="form-control-position">
                                            <i class="la la-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="login">Login Time</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="login" class="form-control" placeholder="Login Time"
                                            name="login_time_record" readonly="readonly"
                                            value="{{ Carbon\Carbon::createFromTimestamp($record->login_time_record)->isoFormat('HH:mm') }}">
                                        <div class="form-control-position">
                                            <i class="la la-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row last mx-auto">
                                <label class="col-md-3 label-control" for="logout">Logout Time</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" id="timeformat"
                                            placeholder="Date Dropper" name="logout_time_record">
                                        <div class="form-control-position">
                                            <i class="la la-clock-o"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Save
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
<script src="{{ asset('/public/app-assets/vendors/js/extensions/datedropper.min.js ') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/timedropper.min.js ') }}"></script>
<script src="{{ asset('/public/app-assets/js/scripts/extensions/date-time-dropper.min.js ') }}"></script>
@endsection