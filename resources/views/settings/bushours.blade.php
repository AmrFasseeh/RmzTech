@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/timedropper.min.css') }}">
@endsection
@section('content')
<section id="form-repeater">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="repeat-form">Business Hours Settings</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="repeater-default">
                            <div data-repeater-list="car">
                                <div data-repeater-item>
                                    <form class="form" method="POST" action="{{ route('businesshours.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Saturday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_sat_holi" name="is_sat_holi">
                                                    @if ($bushours->is_sat_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_sat">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="sat_open_time"
                                                    id="sat_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->sat_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_sat">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="sat_close_time"
                                                    placeholder="Closing Time" id="sat_close_time"
                                                    value="{{ $bushours->sat_close_time ?? '18:00' }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Sunday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_sun_holi" name="is_sun_holi">
                                                    @if ($bushours->is_sun_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_sun">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="sun_open_time"
                                                    id="sun_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->sun_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_sun">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="sun_close_time"
                                                    placeholder="Closing Time" id="sun_close_time"
                                                    value="{{ $bushours->sun_close_time ?? '18:00' }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Monday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_mon_holi" name="is_mon_holi">
                                                    @if ($bushours->is_mon_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_mon">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="mon_open_time"
                                                    id="mon_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->mon_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_mon">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="mon_close_time"
                                                    placeholder="Closing Time" id="mon_close_time"
                                                    value="{{ $bushours->mon_close_time ?? '18:00' }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Tuesday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_tue_holi" name="is_tue_holi">
                                                    @if ($bushours->is_tue_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_tue">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="tue_open_time"
                                                    id="tue_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->tue_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_tue">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="tue_close_time"
                                                    placeholder="Closing Time" id="tue_close_time"
                                                    value="{{ $bushours->tue_close_time ?? '18:00' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Wednesday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_wed_holi" name="is_wed_holi">
                                                    @if ($bushours->is_wed_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_wed">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="wed_open_time"
                                                    id="wed_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->wed_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_wed">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="wed_close_time"
                                                    placeholder="Closing Time" id="wed_close_time"
                                                    value="{{ $bushours->wed_close_time ?? '18:00' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Thursday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_thu_holi" name="is_thu_holi">
                                                    @if ($bushours->is_thu_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_thu">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="thu_open_time"
                                                    id="thu_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->thu_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_thu">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="thu_close_time"
                                                    placeholder="Closing Time" id="thu_close_time"
                                                    value="{{ $bushours->thu_close_time ?? '18:00' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="email-addr">Day</label>
                                                <br>
                                                <h4 class="mt-1">Friday</h4>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3">
                                                <label for="is_holi">Is Holiday</label>
                                                <br>
                                                <select class="form-control is_holi is_fri_holi" name="is_fri_holi">
                                                    @if ($bushours->is_fri_holi == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                    @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-1 col-sm-12 col-md-3" id="open_fri">
                                                <label for="open_time">Opening Time</label>
                                                <br>
                                                <input type="text" class="form-control open_time" name="fri_open_time"
                                                    id="fri_open_time" placeholder="Opening Time"
                                                    value="{{ $bushours->fri_open_time ?? '10:00' }}">
                                            </div>
                                            <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-3"
                                                id="close_fri">
                                                <label for="close_time">Closing Time</label>
                                                <br>
                                                <input class="form-control close_time" type="text" name="fri_close_time"
                                                    placeholder="Closing Time" id="fri_close_time"
                                                    value="{{ $bushours->fri_close_time ?? '18:00' }}">
                                            </div>
                                        </div>
                                        <div class="form-group text-right">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary">Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('/public/assets/js/business-hours.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/timedropper.min.js') }}"></script>
@endsection