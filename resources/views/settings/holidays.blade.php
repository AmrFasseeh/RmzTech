@extends('Master.layout')
@section('content')
<section id="form-repeater">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="repeat-form">Repeating Forms</h4>
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
                        <div class="repeater-default">
                            <div data-repeater-list="holiday">
                                <div data-repeater-item>
                                    <form class="form row repeater_form" id="" method="POST">
                                        <div class="form-group mb-1 col-sm-12 col-md-3">
                                            <label for="title">Holiday Name</label>
                                            <br>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Holiday Name">
                                        </div>
                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="start">Start Date</label>
                                            <br>
                                            <input type="text" class="form-control" id="start" placeholder="Start Date"
                                                name="start">
                                        </div>
                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="end" class="cursor-pointer">End Date</label>
                                            <br>
                                            <input type="text" class="form-control" id="end" placeholder="Start Date"
                                                name="end">
                                        </div>
                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="color">Color</label>
                                            <br>
                                            <select class="form-control" id="color" name="color">
                                                <option>Select Option</option>
                                                <option value="#fff">Black</option>
                                                <option value="#000">White</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                            <div class="row">
                                                <div class="col-md-6"><input type="submit" class="submit"
                                                        class="btn btn-success" value="Save" /></div>
                                                <div class="col-md-6"><button type="button" class="btn btn-danger"
                                                        data-repeater-delete> <i class=""></i>
                                                        Delete</button></div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group overflow-hidden">
                                <div class="col-12">
                                    <button data-repeater-create class="btn btn-primary">
                                        <i class="ft-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Form repeater section end -->
@endsection
@section('scripts')
<script src="{{ asset('public/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script>
    $(document).ready(function (){
        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
        $(".repeater-default").repeater();
        $('.repeater_form').on('submit', function(event) {
            event.preventDefault();
            console.log($('.repeater').repeaterVal());
            
            $.ajax({
                url: SITEURL + "/ajax/saveholiday",
                data: $(this).serialize(),
                type: "POST",
                success: function (data) {
                            $('.repeater_form')[0].reset();
                            console.log("Added Successfully");
                            console.log(data);
                            return true;
                            },
                            error: function(data){ 
                            alert("error!!!!");
                            console.log(data);
                            }
                          });
            });
        });
</script>
@endsection