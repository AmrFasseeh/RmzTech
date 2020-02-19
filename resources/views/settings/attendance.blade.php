@extends('Master.layout')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-form">Settings Page</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('settings.store') }}">
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Daily flexible hours</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_hr">Starting Hour</label>
                                    <small> - From 0 to 24</small>
                                    <input type="number" id="start_hr" class="form-control" placeholder="Starting Hour"
                                        name="start_hr" value="{{ $settings->start_hr ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_hr">Ending Hour</label>
                                    <small> - From 0 to 24</small>
                                    <input type="number" id="end_hr" class="form-control" placeholder="Ending Hour"
                                        name="end_hr" value="{{ $settings->end_hr ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <h4 class="form-section"><i class="la la-clock-o"></i> State number of hours if Employee didn't
                            checkout</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="within_flex">Logged within flexiable hours</label>
                                    <input type="number" id="within_flex" class="form-control"
                                        placeholder="Number of working hours" name="within_flex"
                                        value="{{ $settings->within_flex ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="after_flex">Logged after flexiable hours</label>
                                    <input type="number" id="after_flex" class="form-control"
                                        placeholder="Number of working hours" name="after_flex"
                                        value="{{ $settings->after_flex ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <h4 class="form-section"><i class="la la-clock-o"></i> Late penalty multiplier</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="within_flex">Specify the penalty multiplier</label>
                                    <div class="card-content collapse show">
                                        <div class="form-group">
                                            <select class="select2 form-control" name="penalty_multiplier">
                                                <option value="0" {{ $settings->penalty_multiplier == 0 ? 'selected' : '' }}>No Penalty</option>
                                                <option value="0.5" {{ $settings->penalty_multiplier == 0.5 ? 'selected' : '' }}>Add half late hours</option>
                                                <option value="1" {{ $settings->penalty_multiplier == 1 ? 'selected' : '' }}>Add late hours</option>
                                                <option value="1.5" {{ $settings->penalty_multiplier == 1.5 ? 'selected' : '' }}>Add 1.5 of late hours</option>
                                                <option value="2" {{ $settings->penalty_multiplier == 2 ? 'selected' : '' }}>Add double late hours</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
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
@endsection