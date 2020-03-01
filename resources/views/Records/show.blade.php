@extends('Master.layout')
@section('content')
<div class="container">
    <!-- Default ordering table -->
    <div class="row mt-2">
        {{-- <div class="col-xl-9 col-md-6">
            <p class="card-text">Check out the whole users table
            </p>
        </div> --}}
        {{-- {{ dd($day) }} --}}
        @if (isset($totalhrs))
        @if(isset($day))
        @hour(['totalhrs' => $totalhrs])
        Total Hours on {{ $day->englishDayOfWeek .', '
            . $day->day .', '
            . $day->englishMonth .', '
            . $day->year }}
        @endhour
        @elseif(isset($month))
        @hour(['totalhrs' => $totalhrs])
        Total Hours in {{ date("F", mktime(0, 0, 0, $month ?? 0, 10) ) }}
        Expected Hours this month {{ $wkHours }}
        @endhour
        @endif
        @else
        {{-- @hour(['totalhrs' => 'No check-outs yet!'])
        Total Hours on {{ $day->englishDayOfWeek .', '
            . $day->day .', '
            . $day->englishMonth .', '
            . $day->year }}
        @endhour --}}
        @endif
    </div>
    <!-- File export table -->
    <section id="file-export">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Employees records</h4>
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
                            <p class="card-text">You can export the employees records into different formats.</p>
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        @if (isset($day))
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        @elseif(isset($month))
                                        <th>Month</th>
                                        @else
                                        <th>Date</th>
                                        @endif
                                        <th>Total Hours</th>
                                        @if (isset($status))
                                        <th>Attitude</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($users) }} --}}
                                    @forelse ($users as $user)
                                    @if ($user->logout_time_record)
                                    <tr>
                                        @else
                                    <tr style="background-color: #ff163540;">
                                        @endif
                                        <td><a
                                                href="{{ route('show.single', ['user' => $user->user_id]) }}">{{ $user->name_record }}</a>
                                        </td>
                                        @if (isset($day))
                                        <td>{{ Carbon\Carbon::createFromTimestamp($user->login_time_record) }}</td>
                                        @if ($user->logout_time_record)
                                        <td>{{ Carbon\Carbon::createFromTimestamp($user->logout_time_record) }}</td>
                                        @else
                                        <td>Didn't check-out yet!</td>
                                        @endif
                                        @elseif($month)
                                        <td>{{ __('app.'.Carbon\Carbon::createFromTimestamp($user->login_time_record)->englishMonth) .', '. Carbon\Carbon::createFromTimestamp($user->login_time_record)->year }}
                                        </td>
                                        @elseif($year)

                                        @endif
                                        {{-- <td>{{ Carbon\Carbon::createFromTimestamp($user->logout_time_record)->toDateTimeString() }}
                                        </td>
                                        <td>{{ $wkhrs[$user->id] ?? '' }}</td> --}}
                                        {{-- {{ dd($wkhrs) }} --}}
                                        @if (isset($emptotal[$user->user_id]))
                                        <td>{{ $emptotal[$user->user_id] ?? '' }}
                                            @if (isset($day))
                                        </td>
                                        @else
                                            @if (isset($expected_wkHours))
                                            <span class="danger" style="font-weight:bold">{{ __('out of') }}
                                        </span>{{ $expected_wkHours[$user->user_id].' '.__('expected hours') ?? ''  }}
                                        </td>
                                        @else
                                        </td>
                                        @endif
                                        @endif
                                        @else
                                        <td>Didn't checkout yet!</td>
                                        @endif

                                        @if (isset($status[$user->user_id]))
                                        <td>
                                            <p
                                                class="{{ ($status[$user->user_id] != NULL) ? $status[$user->user_id] : '' }}">
                                                {{ ($status[$user->user_id] != NULL) ? strtoupper($status[$user->user_id]) : '' }}
                                            </p>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <td>No valid records available!</td>
                                    <td></td>
                                    <td></td>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        @if (isset($day))
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        @elseif(isset($month))
                                        <th>Month</th>
                                        @else
                                        <th>Date</th>
                                        @endif
                                        <th>Total Hours</th>
                                        @if (isset($status))
                                        <th>Attitude</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- File export table -->
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