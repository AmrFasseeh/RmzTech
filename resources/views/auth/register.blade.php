@extends('Master.layout')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row mb-1">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0 pb-0">
                                <div class="card-title text-center">
                                    <img src="{{ asset('/public/app-assets/images/logo.png') }}" alt="Rmz Tech"
                                        style="height:40px; width:150px">
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                    <span>Please Sign Up</span></h6>

                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('register') }}"
                                        novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" name="username" id="username"
                                                        class="form-control" placeholder="User Name" tabindex="1"
                                                        value="{{ old('username') }}">
                                                    <div class="form-control-position">
                                                        <i class="ft-user"></i>
                                                    </div>
                                                    <div class="help-block font-small-3">
                                                        @error('username')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" name="fullname" id="fullname" class="form-control"
                                                        placeholder="Full Name" tabindex="2" value="{{ old('name') }}">
                                                    <div class="form-control-position">
                                                        <i class="ft-user"></i>
                                                    </div>
                                                    <div class="help-block font-small-3">
                                                        @error('fullname')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="number" name="phone" id="phone" class="form-control"
                                                placeholder="Phone Number" tabindex="3" required
                                                data-validation-required-message="Please enter your Number."
                                                value="{{ old('phone') }}">
                                            <div class="form-control-position">
                                                <i class="ft-user"></i>
                                            </div>
                                            <div class="help-block font-small-3">
                                                @error('phone')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Email Address" tabindex="4" required
                                                data-validation-required-message="Please enter email address."
                                                value="{{ old('email') }}">
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                            <div class="help-block font-small-3">
                                                @error('email')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </fieldset>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" name="password" id="password"
                                                        class="form-control" placeholder="Password" tabindex="5"
                                                        required>
                                                    <div class="form-control-position">
                                                        <i class="la la-key"></i>
                                                    </div>
                                                    <div class="help-block font-small-3">
                                                        @error('password')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" name="password_confirmation"
                                                        id="password_confirmation" class="form-control"
                                                        placeholder="Confirm Password" tabindex="6"
                                                        data-validation-matches-match="password"
                                                        data-validation-matches-message="Password & Confirm Password must be the same.">
                                                    <div class="form-control-position">
                                                        <i class="la la-key"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>
                                            </div>
                                            <div class="row mb-1 ml-1">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <fieldset>
                                                        <label for="gender">Gender: </label>
                                                        <input type="radio" name="gender" value="1"> Male
                                                        <input type="radio" name="gender" value="0"> Female
                                                    </fieldset>
                                                    <div class="help-block font-small-3">
                                                        @error('gender')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1 ml-1">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <fieldset>
                                                        <label for="isAdmin">Admin: </label>
                                                        <input type="checkbox" name="permissions" value="1">
                                                        <label for="isAdmin"> Yes</label>
                                                    </fieldset>
                                                    <div class="help-block font-small-3">
                                                        @error('permissions')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-4 col-sm-3 col-md-3">
                                                <fieldset>
                                                    <input type="checkbox" name="remember" id="remember"
                                                        class="chk-remember">
                                                    <label for="remember"> I Agree</label>
                                                </fieldset>
                                            </div>
                                            <div class="col-8 col-sm-9 col-md-9">
                                                <p class="font-small-3">By clicking Register, you agree to the <a
                                                        href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and
                                                        Conditions</a> set out by this site, including our Cookie Use.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <button type="submit" class="btn btn-info btn-lg btn-block"><i
                                                        class="ft-user"></i> Register</button>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <a href="{{ route('login') }}"
                                                    class="btn btn-danger btn-lg btn-block"><i class="ft-unlock"></i>
                                                    Login</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection