@extends('layouts.app')

@section('content')
<div class="row login-content justify-content-center">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 col-12 offset-lg-3">
                <div class="card p-md-5 ">
                    <div class="card-body">
                        <center>
                            <h4>Log In</h4>
                            <span>Log in to your account to continue</span>
                        </center>
                        <div class="">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="my-2" for="">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <!-- <i class="bi bi-person-circle"></i> -->
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Type your email" required
                                            autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="my-2" for="">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Type your password" required autocomplete="current-password">
                                        <div class="password-hide-show">  <span class="iconify password-icon" data-icon="el:eye-close"></span> </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <a href="{{url('forgotpassword')}}" style="float: right;color:rgb(167, 167, 167);padding:5px 0px;">Forgot Password ? </a>
                                <div class="form-group text-right">
                                    <button type="submit" class="form-control btn btn-danger mb-3 ">Log in</button>
                                </div>
                            </form>
                        </div>
                        <center>
                            <span>© {{date("Y")}} All Rights Reserved. <a href="https://ccninfotech.com/" class="company-name">CCN Infotech Ltd.</a> </span>
                        </center>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('custom-js')
    <script type="text/javascript">
        $(".password-hide-show").click(function () {
            if ($("#password").attr("type") === "password") {
                $('#password').attr("type", "text")
            }else{
                $('#password').attr("type", "password")
            }
        })
    </script>
@endpush

