@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/colors/palette-gradient.min.css ') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/fonts/line-awesome/css/line-awesome.min.css ') }}">


@endsection
@section('content')
<div class="row mt-2 mb-2">
    <div class="col-xl-9 col-md-6">
        <h1>Employee: {{ $user->fullname }}</h1>
        <h4 class="mt-1">Email: {{ $user->email }}</h4>
    </div>
    @if (isset($totalhrs))
    <div class="col-xl-3 col-md-6 col-12">
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
    @else

    @endif
    <div class="row mt-1 mb-2 ml-1">
        <div class="form-group">
            <!-- button group -->
            <h2>Filter by Month</h2>
            <div class="btn-group mt-1" role="group" aria-label="Basic example">

                @forelse ($months as $month)
                <a href="{{ route('show.monthly', ['user' => $user->id, 'month' => $month->login_mo_record ]) }}"
                    class="btn btn-primary">{{ date("F", mktime(0, 0, 0, $month->login_mo_record, 10)) }}</a>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

<!-- Default ordering table -->
<div class="container">
    <section id="ordering">
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
                        <div class="card-body card-dashboard">
                            <p class="card-text">Check out your attendance
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered default-ordering">
                                    <thead>
                                        <tr>
                                            <th>Login Time</th>
                                            <th>Logout Time</th>
                                            <th>Working Hours</th>
                                            <th>Edit</th>
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
                                            <td>Assumed {{ $wkhrs[$record->id] }}</td>
                                            @endif
                                            @if ($record->logout_time_record > $record->login_time_record)
                                            <td></td>
                                            @else
                                            <td>
                                                <div class="fonticon-wrap"><a
                                                        href="{{ route('edit.Urecord', ['record' => $record->id]) }}"><i
                                                            class="la la-edit"></i></a></div>
                                            </td>
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
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--/ Default ordering table -->
@endsection