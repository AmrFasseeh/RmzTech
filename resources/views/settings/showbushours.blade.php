@extends('Master.layout')
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Working Schedule</h4>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th>Starting Time</th>
                                        <th>Ending Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($week_day as $day)
                                    <tr>
                                        <td>{{ strtoupper($day) }}</td>
                                        @if ($bushours->{'is_'.$day.'_holi'} == 1)
                                        <td colspan="3" style="text-align:center"> Weekend!</td>
                                        @else
                                        <td>Business Day</td>
                                        <td>{{ $bushours->{$day.'_open_time'} }}</td>
                                        <td>{{ $bushours->{$day.'_close_time'} }}</td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th>Starting Time</th>
                                        <th>Ending Time</th>
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
@endsection