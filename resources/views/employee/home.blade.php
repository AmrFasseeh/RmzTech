@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('/public/app-assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/calendars/fullcalendar.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/colors/palette-gradient.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/plugins/calendars/fullcalendar.min.css') }}">

@endsection
@section('content')

<div class="row justify-content-center mt-2">
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-info bg-darken-2 rounded-left">
              <i class="la la-calendar font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-info text-white media-body rounded-right">
              <h5 class="text-white">Events in {{ $thisMonth }}</h5>
              <h5 class="text-white text-bold-400 mb-0" id="events">{{ $events }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-success bg-darken-2 rounded-left">
              <i class="la la-calendar-check-o font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-success text-white media-body rounded-right">
              <h5 class="text-white">Holidays in {{ $thisMonth }}</h5>
              <h5 class="text-white text-bold-400 mb-0">{{ $holidays }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-warning bg-darken-2 rounded-left">
              <i class="icon-clock font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-warning text-white media-body rounded-right">
              <h5 class="text-white">Checked-In</h5>
              <h5 class="text-white text-bold-400 mb-0">{{ $checkin }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-danger bg-darken-2 rounded-left">
              <i class="icon-check font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-danger text-white media-body rounded-right">
              <h5 class="text-white">Checked-Out</h5>
              <h5 class="text-white text-bold-400 mb-0">{{ $checkout }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-light">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('/public/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/vendors/js/extensions/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/public/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}"></script>
<script>
  $(document).ready(function () {           
           var SITEURL = "{{url('/')}}";
           $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
  $("#calendar").fullCalendar({ 
    timeZone: 'Africa/Cairo',
    header: { left: "prev,next today",
    center: "title", right: "month,agendaWeek,agendaDay,listMonth" },
    eventSources: [
      SITEURL + '/ajax/populatecalendar',
      SITEURL + '/ajax/getholidays',
    ],
    eventRender: function (event, element, view) {
      console.log(element);
      
                  if (event.allDay === 'true') {
                      event.allDay = true;
                  } else {
                      event.allDay = false;
                  }
              
              },
    editable: 0,
    droppable: 0,
    selectable: 0,
    selectHelper: 0,
              
    // defaultView: 'agendaWeek',
    businessHours: [{
  // days of week. an array of zero-based day of week integers (0=Sunday)
      dow: [ {{ $days['sun'] }} ], start: '{{ $work->sun_open_time }}', end: '{{ $work->sun_close_time }}' },
      {dow: [ {{ $days['mon'] }} ], start: '{{ $work->mon_open_time }}', end: '{{ $work->mon_close_time }}'}, 
      {dow: [ {{ $days['tue'] }} ], start: '{{ $work->tue_open_time }}', end: '{{ $work->tue_close_time }}'},
      {dow: [ {{ $days['wed'] }} ], start: '{{ $work->wed_open_time }}', end: '{{ $work->wed_close_time }}'}, 
      {dow: [ {{ $days['thu'] }} ], start: '{{ $work->thu_open_time }}', end: '{{ $work->thu_close_time }}'},
      {dow: [ {{ $days['fri'] }} ], start: '{{ $work->fri_open_time }}', end: '{{ $work->fri_close_time }}'},
      {dow: [ {{ $days['sat'] }} ], start: '{{ $work->sat_open_time }}', end: '{{ $work->sat_close_time }}'}
  ],
          
  });
});
</script>
@endsection