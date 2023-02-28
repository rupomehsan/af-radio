@extends('layouts.app')

@section('content')
<div class="row login-content justify-content-center">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 col-12 offset-lg-3">
                <div class="card p-5">
                    <div class="card-body">
                        <center>
                          <h4>Password Recovery</h4>
                          <span>Enter your phone number & the instructions will be sent to you</span>
                        </center>
                        <div class="login-submit-form">
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

                                <div class="form-group text-right">
                                    <button type="submit" class="form-control btn btn-danger mb-3 ">Send</button>
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
