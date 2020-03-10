@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/colors/palette-gradient.min.css ') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/fonts/line-awesome/css/line-awesome.min.css ') }}">


@endsection
@section('content')
<div class="row mt-2 mb-2">
    <div class="col-xl-6 col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success rounded-left">
                        @if (isset($user->image))
                        <img src="{{ $user->image->url() }}" class="rounded-circle  height-100">
                        @else
                        <img src="{{ asset('/public/assets/rmz-logos/icon.png') }}" class="rounded-circle  height-100">
                        @endif
                    </div>
                    <div class="p-2 media-body">
                        <h3>{{ $user->fullname }}</h3>
                        <h5 class="text-bold-400">{{ $user->email }}</h5>
                        <h5 class="text-bold-400 mb-0">{{ Carbon\Carbon::make($user->time_user)->toDateString() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-md-6 col-6"></div>
</div>
<div class="row mt-1 mb-1">
    @if (isset($wkdays))
    <div class="col-xl-6 col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="danger">{{ count($wkdays) ?? '' }} Days</h3>
                            <span>Total Days in {{ date("F", mktime(0, 0, 0, $currMonth, 10)) }}</span>
                        </div>
                        <div class="align-self-center">
                            <i class="la la-history danger font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (isset($totalhrs))
    <div class="col-xl-6 col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="danger">{{ $totalhrs }}</h3>
                            <span>Total Hours in {{ date("F", mktime(0, 0, 0, $currMonth, 10)) }}</span>
                        </div>
                        <div class="align-self-center">
                            <i class="la la-history danger font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
</div>

<!-- Default ordering table -->
<div class="container">
    <section id="file-export">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendance table</h4>
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
                        <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                            <p class="card-text">Check out your attendance</p>
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                    <tr>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Working Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($records as $record)
                                    @if ( Carbon\Carbon::createFromTimestamp($record->logout_time_record) >
                                    Carbon\Carbon::createFromTimestamp($record->login_time_record))
                                    <tr>
                                        @else
                                    <tr style="background-color: #ff163540;">
                                        @endif
                                        <td>{{ Carbon\Carbon::createFromTimestamp($record->login_time_record)->toDateTimeString()}}
                                        </td>
                                        @if ( Carbon\Carbon::createFromTimestamp($record->logout_time_record) >
                                        Carbon\Carbon::createFromTimestamp($record->login_time_record))
                                        <td>{{ Carbon\Carbon::createFromTimestamp($record->logout_time_record)->toDateTimeString() }}
                                        </td>
                                        <td>{{ $wkhrs[$record->id] }}</td>
                                        @else
                                        <td>Didn't logout this day!</td>
                                        @if ($record->logout_time_record > $record->login_time_record)
                                        <td>{{ $wkhrs[$record->id] }}</td>
                                        @else
                                        <td>Didn't log out, assumed {{ $wkhrs[$record->id] }}</td>
                                        @endif
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>There are no records for this user!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Working Hours</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--/ Default ordering table -->
@endsection
@section('scripts')
<script src="{{ asset('/public/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/jszip.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/pdfmake.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/tables/buttons.print.min.js') }}"></script>

<script src="{{ asset('/public/app-assets/js/scripts/tables/datatables/datatable-advanced.min.js') }}"></script>
@endsection