@extends('Master.layout')
@section('styles')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/app-assets/css/core/colors/palette-gradient.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/public/app-assets/css/pages/users.min.css') }}">
<!-- END: Page CSS-->
<style>
    .p-2.media-body {
    word-break: break-word;
}
</style>
@endsection
@section('content')
<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        
        <div class="content-body">
            <!-- Simple User Cards -->
            <section id="simple-user-cards" class="row">
                <div class="col-12">

                    <h3 class="text-uppercase">View Users</h3>
                    <hr>
                </div>
                @foreach ($emps as $emp)

                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-{{ $bg[$emp->id] }} rounded-left">
                                    @if (isset($emp->image))
                                    <img src="{{ $emp->image->url() }}" class="rounded-circle  height-100">
                                    @else
                                    <img src="{{ asset('/public/assets/rmz-logos/icon.png') }}" class="rounded-circle  height-100">
                                    @endif
                                </div>
                                <div class="p-2 media-body">
                                    <h5>{{ $emp->fullname }}</h5>
                                    <h6 class="text-bold-400">{{ $emp->email }}</h6>
                                    <h6 class="text-bold-400 mb-0">{{ Carbon\Carbon::make($emp->time_user)->toDateString() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endsection
            @section('scripts')
            <script src="{{ asset('/public/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
            @endsection