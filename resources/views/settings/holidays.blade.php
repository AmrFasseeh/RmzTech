@extends('Master.layout')
@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{ asset('public/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('public/app-assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/vendors/css/extensions/datedropper.min.css') }}">
<style>
    .red-row {
        background-color: #f0134d;
    }

    .yellow-row {
        background-color: #ffcc00;
    }

    .green-row {
        background-color: #b7e778;
    }

    .dkgreen-row {
        background-color: #1fab89;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-7">
        <section id="odata-service">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Registered Holidays</h4>
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
                            <div class="card-body card-dashboard ">
                                <div id="serviceScenario"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="row-separator-card-center">Register Holidays</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
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

                    <div class="card-text">
                        <p></p>
                    </div>

                    <form class="form form-horizontal row-separator" id="holiday_form" method="POST">
                        {{-- {{ csrf_field() }} --}}
                        <div class="form-body">

                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="title">Holiday</label>
                                <div class="col-md-9">
                                    <input type="text" id="title" class="form-control" placeholder="Title" name="title">
                                </div>
                            </div>

                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="start">Start Date</label>
                                <div class="col-md-9">
                                    <input type="text" id="start" class="form-control" placeholder="Start date"
                                        name="start">
                                </div>
                            </div>

                            <div class="form-group row mx-auto">
                                <label class="col-md-3 label-control" for="end">End Date</label>
                                <div class="col-md-9">
                                    <input type="text" id="end" class="form-control" placeholder="End date" name="end">
                                </div>
                            </div>

                            <div class="form-group row last mx-auto">
                                <label class="col-md-3 label-control" for="color">Color</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control" name="color" id="color">
                                        <optgroup label="Holiday type">
                                            <option style="background-color: #f0134d" value="#f0134d">Red</option>
                                            <option style="background-color: #ffcc00" value="#ffcc00">Yellow</option>
                                            <option style="background-color: #b7e778" value="#b7e778">Green</option>
                                            <option style="background-color: #1fab89" value="#1fab89">Dark Green
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-check"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('public/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('public/app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}"></script>
<script src="{{ asset('public/app-assets/vendors/js/tables/jsgrid/griddata.js') }}"></script>
<script src="{{ asset('public/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

<script src="{{ asset('/public/app-assets/vendors/js/extensions/datedropper.min.js') }}"></script>
{{-- <script src="{{ asset('/public/app-assets/js/scripts/extensions/date-time-dropper.min.js') }}"></script> --}}

<script>
    $(document).ready(function (){
        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
        // $(".repeater-default").repeater();
        $('#holiday_form').on('submit', function(event) {
            event.preventDefault();
            console.log(SITEURL + "/ajax/saveholiday");
            
            $.ajax({
                url: SITEURL + "/ajax/saveholiday",
                data: $(this).serialize(),
                type: "POST",
                success: function (data) {
                            $('#holiday_form').trigger("reset");
                            console.log("Added Successfully");
                            console.log(data);
                            loadHolidays()
                            return true;
                            },
                            error: function(data){ 
                            alert("error!!!!");
                            console.log(data);
                            }
                          });
            });

function loadHolidays() {

            $("#serviceScenario").jsGrid({
                height:"auto",
                width:"100%",
                sorting:!0,
                paging:!1,
                autoload:!0,
                controller:{

                    loadData: function(filter) {
                                    return $.ajax({
                                    type: "GET",
                                    url: SITEURL + '/holidays',
                                    data: filter,
                                    success: function (data) {
                                                    console.log('Data loaded!');
                                                    console.log(data);
                                                    // filter.resolve(data.Response);
                                                    
                                                            },
                                                })
                                        }},
                fields:[
                    {name:"title",title:"Title",type:"text"},
                    {name:"start",title:"Start Date",type:"date",width:100},
                    {name:"end",title:"End Date",type:"textarea",width:100},
                    {name:"color",title:"Type",type:"text",width:50}
                    ],
                    
                    });
                    $("table.jsgrid-table tbody tr").each(function() {
                    console.log('there');  
                });
                }
                loadHolidays();
                $("table.jsgrid-table tbody tr td:nth-child(1)").each(function () {
                        if ($(this).text() == "#f0134d") {
                            $(this).parent("tr").addClass("red-row");
                        }
                         });
                $("#start").dateDropper({dropWidth:200,format:"Y-m-d"});
                $("#end").dateDropper({dropWidth:200,format:"Y-m-d"});
    });
</script>
@endsection