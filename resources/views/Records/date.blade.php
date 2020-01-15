@extends('Master.layout')
@section('content')
<div class="container mt-2">
    @if (isset($years))
    <p>Select a year to filter the records</p>
    @date
    @forelse ($years as $year)
    <a class="btn btn-primary"
        href="{{ route('records.yearly', ['year' => $year->login_yr_record]) }}">{{ $year->login_yr_record }}</a>
    @empty
    <p>No data available!</p>
    @endforelse
    @enddate
    @endif


    @if (isset($months))
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Filter by Month:</h2>
                @date
                @forelse ($months as $month)
                <a class="btn btn-primary mt-1"
                    href="{{ route('records.monthly', ['year' => $month->login_yr_record, 'month' => $month->login_mo_record ]) }}">
                    {{ date("F", mktime(0, 0, 0, $month->login_mo_record, 10)) }}</a>
                @empty
                <p>No data available!</p>
                @endforelse
                @enddate
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Filter by Days:</h2>
                @date
                @forelse ($months as $month)
                <a class="btn btn-secondary mb-1 mt-1"
                    href="{{ route('records.daily', ['year' => $month->login_yr_record, 'month' => $month->login_mo_record ]) }}"><small>Days
                        of</small>
                    {{ date("F", mktime(0, 0, 0, $month->login_mo_record, 10)) }}</a>
                @empty
                <p>No data available!</p>
                @endforelse
                @enddate
            </div>
        </div>
    </div>
    @endif
    @if (isset($days))
    <h2>Select a specific day:</h2>
    @date
    @forelse ($days as $day)
    <a class="btn btn-primary mb-1 mt-1" href="{{ route('show.daily', ['year' => $day->login_yr_record, 
        'month' => $day->login_mo_record, 
        'day' => $day->login_dy_record ]) }}">{{ $day->login_dy_record }}</a>
    @empty
    <p>No data available!</p>
    @endforelse
    @enddate
    @endif
</div>
@endsection