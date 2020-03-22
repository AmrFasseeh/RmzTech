@extends('Master.layout')
@section('content')
<div id="app" class="container mt-2">
    <div class="row">
        <div class="col-12">
            <div v-if="yearsAvailable">
                <h2>Select a year to filter the records</h2>
                <a class="btn btn-primary mb-1" href="#" v-for="year in years"
                    @click="selectYear(year.login_yr_record)">@{{ year.login_yr_record }}</a>
                <div v-if="years.length <= 0">
                    <p>No data available</p>
                </div>
            </div>
            <div v-else-if="!yearsAvailable">
                <h2>No records for this user yet!</h2>
            </div>
        </div>

        <div class="col-12">
            <div v-if="monthsAvailable">
                <h2>Filter by Month:</h2>
                <a class="btn btn-primary mt-1 mr-1 mb-1" :href="goToRecords(month.login_yr_record,month.login_mo_record)"
                    v-for="month in months">@{{ month.login_mo_record }}</a>
                <div v-if="months.length <= 0">
                    <p>No data available</p>
                </div>
            </div>
        </div>
    </div>
    {{-- 


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
@endif --}}
</div>
@endsection
@section('scripts')
<script>
    var SITEURL = "{{url('/')}}";
var app = new Vue({
    el: '#app',
    data() {
        return {
            years: [],
            months: [],
            monthsAvailable: false,
        }
    },
    methods: {
        selectYear(year) {
            axios.get(SITEURL + '/ajax/listmonths/' + year)
    .then(response => {
        this.months = response.data
        this.monthsAvailable = true
    })
    console.log(this.months);
    
        },
        goToRecords(year, month) {
            return SITEURL +'/empMonth/'+ year +'/'+ month
        }
    },
        computed: {
            yearsAvailable() {
            if(this.years.length > 0){
                console.log('true');
                console.log(this.years);
                
                
            return true
            } else {
                console.log('false');
                
                return false
            }
        }
        },
    mounted: function () {
        axios.get(SITEURL+'/ajax/listyears')
    .then(response => (this.years = response.data))
    }
})
</script>
@endsection