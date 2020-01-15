@extends('Master.layout')
@section('content')
<div class="container">
    <!-- Default ordering table -->
    <div class="row mt-2">
        {{-- <div class="col-xl-9 col-md-6">
            <p class="card-text">Check out the whole users table
            </p>
        </div> --}}
        @if (isset($totalhrs))
        @if(isset($day))
        @hour(['totalhrs' => $totalhrs])
        Total Hours on {{ Carbon\Carbon::createFromTimestamp($day)->englishDayOfWeek .', '
        . Carbon\Carbon::createFromTimestamp($day)->day .', '
        . Carbon\Carbon::createFromTimestamp($day)->englishMonth .', '
        . Carbon\Carbon::createFromTimestamp($day)->year }}
        @endhour
        @elseif(isset($month))
        @hour(['totalhrs' => $totalhrs])
        Total Hours in {{ date("F", mktime(0, 0, 0, $month ?? 0, 10) ) }}
        @endhour
        @endif
        @else

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
                            <p class="card-text">Exporting data from a table can often be a key part of a complex
                                application. The Buttons extension for DataTables provides three plug-ins that provide
                                overlapping functionality for data export.</p>
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        @if (isset($day))
                                        <th>Day</th>
                                        @elseif(isset($month))
                                        <th>Month</th>
                                        @else
                                        <th>Date</th>
                                        @endif
                                        <th>Total Hours</th>
                                        <th>Attitude</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)

                                    <tr>
                                        <td><a
                                                href="{{ route('show.single', ['user' => $user->user_id]) }}">{{ $user->name_record }}</a>
                                        </td>
                                        @if (isset($day))
                                        <td>{{ Carbon\Carbon::createFromTimestamp($day)->englishDayOfWeek .', '
                                            . Carbon\Carbon::createFromTimestamp($day)->day .', '
                                            . Carbon\Carbon::createFromTimestamp($day)->englishMonth }}</td>
                                        @elseif($month)
                                        <td>{{ Carbon\Carbon::createFromTimestamp($user->login_time_record)->englishMonth .', '. Carbon\Carbon::createFromTimestamp($user->login_time_record)->year }}
                                        </td>
                                        @elseif($year)

                                        @endif
                                        {{-- <td>{{ Carbon\Carbon::createFromTimestamp($user->logout_time_record)->toDateTimeString() }}
                                        </td>
                                        <td>{{ $wkhrs[$user->id] ?? '' }}</td> --}}
                                        <td>{{ $emptotal[$user->user_id] }}</td>
                                        @if (isset($status[$user->user_id]))
                                        <td><p class="{{ $status[$user->user_id] }}">{{ strtoupper($status[$user->user_id]) }}</p></td>
                                        @else
                                        <td></td>
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
                                        <th>Day</th>
                                        @elseif(isset($month))
                                        <th>Month</th>
                                        @else
                                        <th>Date</th>
                                        @endif
                                        <th>Total Hours</th>
                                        <th>Attitude</th>
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