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
            <i class="icon-calendar font-large-2 text-white"></i>
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
          <div class="p-2 text-center bg-danger bg-darken-2 rounded-left">
            <i class="icon-user font-large-2 text-white"></i>
          </div>
          <div class="p-2 bg-danger text-white media-body rounded-right">
            <h5 class="text-white">Total Employees</h5>
            <h5 class="text-white text-bold-400 mb-0">{{ $emps ?? ''}}</h5>
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
            <i class="icon-calendar font-large-2 text-white"></i>
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
            <i class="icon-check font-large-2 text-white"></i>
          </div>
          <div class="p-2 bg-warning text-white media-body rounded-right">
            <h5 class="text-white">Checked-In</h5>
            <h5 class="text-white text-bold-400 mb-0">{{ $checkins }}</h5>
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

    // $("#try").click(function(){
    //     var url = $(this).attr("data-link");
    //     $.ajax({
    //         url: "test",
    //         type:"POST",
    //         data: { testdata : 'testdatacontent' },
    //         success:function(data){
    //             alert(data);
    //         },error:function(){ 
    //             alert("error!!!!");
    //         }
    //     }); //end of ajax
    // });
           
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
    editable: !0,
    droppable: !0,
    selectable: !0,
    selectHelper:!0,
    select: function (start, end, allDay) {
                  var title = prompt('Event Title:');
                  if (title) {
                      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                      // console.log(SITEURL+"calendar/create");
                      
                      $.ajax({
                          url: SITEURL + "/ajax/createvent",
                          data: 'title=' + title + '&start=' + start + '&end=' + end,
                          type: "POST",
                          success: function (data) {
                              console.log("Added Successfully");
                              console.log(data);
                              $('#events').html(+$('#events').html() + +'1');
                              return true;
                            },
                            error: function(){ 
                              alert("error!!!!");
                            }
                          });
                      $("#calendar").fullCalendar('renderEvent',
                              {
                                  title: title,
                                  start: start,
                                  end: end,
                                  allDay: allDay,
                              },
                      true
                              );
                  }
                  $("#calendar").fullCalendar('unselect');
              },
              
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
  eventDrop: function (event, delta) {
                          var updateMsg = confirm("Do you really want to update this event?");
                          if(updateMsg){
                          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                          $.ajax({
                              url: SITEURL + '/ajax/updatevent',
                              data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                              type: "POST",
                              success: function (response) {
                                  console.log("Updated Successfully");; 
                              }
                            });         
                  } else {
                  $("#calendar").fullCalendar('refetchEvents');
                  console.log('Refetched!!!');
                  
                      }
                    },
          eventClick: function (event) {
                  var deleteMsg = confirm("Do you really want to delete?");
                  if (deleteMsg) {
                      $.ajax({ 
                          type: "POST",
                          url: SITEURL + '/ajax/deletevent',
                          data: "&id=" + event.id,
                          success: function (response) {
                              if(parseInt(response) > 0) {
                                  $('#calendar').fullCalendar('removeEvents', event.id);
                                  console.log("Deleted Successfully");
                              }
                          }
                      });
                  }
              }
          
  });
});
</script>
@endsection