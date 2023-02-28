@extends('layouts.app')

@section('content')
<style>
    .otc {
        position: relative;
        width: 320px;
        margin: 0 auto;
    }

    .otc fieldset {
        border: 0;
        padding: 0;
        margin: 0;
    }

    .otc fieldset div {
        display: flex;
        align-items: center;
    }

    .otc input[type="number"] {
        width: 1em;
        line-height: 1;
        margin: .1em;
        padding: 8px 0 4px;
        font-size: 2.65em;
        text-align: center;
        appearance: textfield;
        -webkit-appearance: textfield;
        border: none;
        border-bottom: 2px solid #FF3D00;
        color: #FF3D00;
    }

    .otc input::-webkit-outer-spin-button,
    .otc input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* 2 group of 3 items */
    .otc input[type="number"]:nth-child(n+4) {
        order: 2;
    }

    .otc input:focus {
        outline: none !important;
        border-color: #719ECE;
    }

    .otc label {
        border: 0 !important;
        clip: rect(1px, 1px, 1px, 1px) !important;
        -webkit-clip-path: inset(50%) !important;
        clip-path: inset(50%) !important;
        height: 1px !important;
        margin: -1px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important;
        white-space: nowrap !important;
    }

    d-none {
        display: none;
    }

</style>
<div class="row login-content justify-content-center">
    <div class="container">
        <div class="row mt-5">
            <div class="showmessage">

            </div>
            <div class="col-lg-6 col-12 offset-lg-3 " id="sendEmail">
                <div class="card p-5">
                    <div class="card-body">
                        <center>
                            <h4>Password Recovery</h4>
                            <span>Enter your Email & the instructions will be sent to you</span>
                        </center>
                        <div class="login-submit-form">
                            <form id="forgotPasswordForm">
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
                                            value="{{ old('email') }}" placeholder="Type your email"
                                            autocomplete="email">

                                    </div>
                                </div>

                                <!-- <button id="submit-button" type="submit"
                                    class="form-control btn btn-primary waves-effect mb-3">
                                <span id="submit-button-loader" class="spinner-border spinner-border-sm d-none"
                                      role="status" aria-hidden="true"></span>
                                Validate OTP
                            </button> -->

                                <div class="form-group text-right">
                                    <button id="forgotPassword" type="submit" class="form-control btn btn-danger mb-3 ">
                                        <span id="submit-button-loader" class="spinner-border spinner-border-sm d-none"
                                            role="status" aria-hidden="true"></span>
                                        Send</button>
                                </div>
                            </form>
                        </div>
                        <center>
                            <span>© {{date("Y")}} All Rights Reserved. <a href="https://ccninfotech.com/" class="company-name">CCN Infotech Ltd.</a> </span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 offset-lg-3 d-none" id="otp">
                <div class="card p-5">
                    <div class="card-body">
                        <div id="otp_content" class="">
                            <div id="otp_heading" class="text-center ">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--bx" width="100" height="100"
                                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" data-icon="bx:bxs-lock"
                                    data-width="100" data-height="100" style="color: rgb(255, 61, 0);">
                                    <path
                                        d="M12 2C9.243 2 7 4.243 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 10.723V20h-2v-2.277a1.993 1.993 0 0 1 .567-3.677A2.001 2.001 0 0 1 14 16a1.99 1.99 0 0 1-1 1.723z"
                                        fill="currentColor"></path>
                                </svg>
                                <h6 id="mailNotification"></h6>
                            </div>
                            <form class="otc" action="/api/v1/auth/admin/verify_otp.php" id="otp_form" name="otp_form"
                                novalidate="">
                                <fieldset>
                                    <label for="otc-1">Number 1</label>
                                    <label for="otc-2">Number 2</label>
                                    <label for="otc-3">Number 3</label>
                                    <label for="otc-4">Number 4</label>
                                    <label for="otc-5">Number 5</label>
                                    <label for="otc-6">Number 6</label>
                                    <div>
                                        <input type="hidden" id="otp_email" name="email" value="">
                                        <input type="hidden" id="otp_code" name="otp_code" value="">
                                        <input type="number" pattern="[0-9]*" value="" inputtype="numeric"
                                            autocomplete="one-time-code" id="otc-1" name="code[]" required="">
                                        <!-- Autocomplete not to put on other input -->
                                        <input type="number" pattern="[0-9]*" min="0" max="9" name="code[]"
                                            maxlength="1" value="" inputtype="numeric" id="otc-2" required="">
                                        <input type="number" pattern="[0-9]*" min="0" max="9" name="code[]"
                                            maxlength="1" value="" inputtype="numeric" id="otc-3" required="">
                                        <input type="number" pattern="[0-9]*" min="0" max="9" name="code[]"
                                            maxlength="1" value="" inputtype="numeric" id="otc-4" required="">
                                        <input type="number" pattern="[0-9]*" min="0" max="9" name="code[]"
                                            maxlength="1" value="" inputtype="numeric" id="otc-5" required="">
                                        <input type="number" pattern="[0-9]*" min="0" max="9" name="code[]"
                                            maxlength="1" value="" inputtype="numeric" id="otc-6" required="">
                                    </div>
                                </fieldset>
                                <span id="code_error"></span>

                                <h6 class="text-center my-5">Didn’t get code? <span class="text-danger">
                                   <button class="btn btn-warning" id="resend">Resend</button> </span>
                                </h6>
                                <button id="sendOtp-button" type="submit" class="form-control btn btn-danger mb-3 ">
                                    <span id="submit-button-loader" class="spinner-border spinner-border-sm d-none"
                                        role="status" aria-hidden="true"></span>
                                    Send OTP
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 offset-lg-3 d-none" id="changePassword">
                <div class="card p-5">
                    <div class="card-body">
                        <center>
                            <h3>Recover  Your Password</h3>
                        </center>
                        <div class="login-submit-form">
                            <form id="recoverPassword">
                                @csrf
                                <input type="hidden" id="rec_email" name="email" value="">
                                <div class="form-group mb-3">
                                    <label class="my-2" for="">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <!-- <i class="bi bi-person-circle"></i> -->
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control"
                                            name="password" value="" placeholder="Type your new_password">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="my-2" for="">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <!-- <i class="bi bi-person-circle"></i> -->
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input id="password_confirmation" type="password" class="form-control"
                                            name="password_confirmation" value="" placeholder="Type your confirm_password">
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button id="recoverPass" type="submit" class="form-control btn btn-danger mb-3 ">
                                    <span id="submit-button-loader" class="spinner-border spinner-border-sm d-none"
                                          role="status" aria-hidden="true"></span>
                                        Send
                                    </button>

                                </div>
                        </div>

                        </form>
                    </div>
                    <center>
                        <span>© {{date("Y")}} All Rights Reserved. <a href="https://ccninfotech.com/" class="company-name">CCN Infotech Ltd.</a> </span>
                    </center>
                </div>
            </div>
            <div class="col-lg-6 col-12 offset-lg-3 d-none" id="loginredirect">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="form-group text-right" style="text-align: center">
                            <h4>You have successfully reset your password! </h4>
                            <span class="iconify my-5" data-icon="clarity:success-standard-solid" style="color: red;text-align: center;
    font-size: 60px !important;
    float: left;
    margin-left: 50%;"></span>
                            <a href="login">
                                <button id="" class="form-control btn btn-danger mb-3 ">
                                        <span id="submit-button-loader" class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                    Go to Login</button>
                            </a>

                        </div>
                    </div>
                    <center>
                        <span>© {{date("Y")}} All Rights Reserved. <a href="https://ccninfotech.com/" class="company-name">CCN Infotech Ltd.</a> </span>
                    </center>
                </div>
            </div>



        </div>

    </div>
</div>
@endsection

@push('custom-js')
<script>
    // $(document).ready(function(){



    //     $('#forgotPassword').click(function(){
    //         alert("hi");
    //     })
    // })

    $(function () {
        $(document).on("click", "#forgotPassword", function (e) {
            e.preventDefault();
            var formData = new FormData($('#forgotPasswordForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: rootUrl+"auth/user/forgot-password",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                beforeSend: function () {
                    $('#forgotPassword').prop('disabled', true);
                    $('#submit-button-loader').removeClass('d-none');
                    $('#submit-icon').addClass('d-none');
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === "success") {
                        toastr.success("Otp Successfully Send");
                        $("#sendEmail").addClass('d-none')
                        $("#otp").removeClass('d-none')
                        $("#mailNotification").append(`
                               <h6>${res.message}<br> <b>"${res.email}"</b><h6/>
                            `)
                        $("#otp_email").val(res.email)
                        $("#rec_email").val(res.email)
                    }
                    // setTimeout(location.reload.bind(location), 1000);
                },
                error: function (err) {
                    console.log("err", err.responseJSON);
                    var data = err.responseJSON
                    if (data.status === 'error') {
                        toastr.error(data.message);
                        $('#submit-button-loader').addClass('d-none');
                        $('#forgotPassword').prop('disabled', false);
                    } else if (data.status === "validate_error") {
                        toastr.error(data.data[0].error);
                        $('#submit-button-loader').addClass('d-none');
                        $('#forgotPassword').prop('disabled', false);
                    }else if (data.status === "server_error") {
                        toastr.error(data.message);

                    }
                },

            });
        });


        $(document).on("click", "#sendOtp-button", function (e) {
            e.preventDefault();
            var email = $('#otp_email').val()

            var values = $("input[name='code[]']").map(function(){return $(this).val();}).get();
            let code = values.join('');
            code = $('#otp_code').val(code)
            // var formData = new FormData('email',email)
            // formData.append('code',code)
            // alert(formData)
            // console.log(email,code);
            var formData = new FormData($('#otp_form')[0]);
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: rootUrl+"auth/user/user-verify",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                beforeSend: function () {
                    // $('#sendOtp-button').prop('disabled', true);
                    $('#submit-button-loader').removeClass('d-none');
                    $('#submit-icon').addClass('d-none');
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === "success") {
                        toastr.success("You OTP Matched...");
                        $("#otp").addClass('d-none')
                        $("#changePassword").removeClass('d-none')
                    }
                    // setTimeout(location.reload.bind(location), 1000);
                },
                error: function (err) {
                    console.log("err", err.responseJSON);
                    var data = err.responseJSON
                    if (data.status === 'error') {
                        toastr.error(data.message);
                        $('#sendOtp-button').prop('disabled', false);
                    } else if (data.status === "validate_error") {
                        toastr.error(data.data[0].error);
                        $('#sendOtp-button').prop('disabled', false);
                    }
                }
            });
        });

        $(document).on("click", "#resend", function (e) {
            e.preventDefault();
            var email = $("#otp_email").val();
            console.log(email);
            $.ajax({
                url: rootUrl+"auth/user/resend-code",
                type: 'POST',
                dataType: "json",
                data: {
                    "email" : email,
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === "success") {
                        toastr.success("Otp Send Your Email Again......");
                    }
                    // setTimeout(location.reload.bind(location), 1000);
                },
                error: function (err) {
                    console.log("err", err);
                }

            });

        });

        $(document).on("click", "#recoverPass", function (e) {
            e.preventDefault();
            var formData = new FormData($('#recoverPassword')[0]);
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: rootUrl+"auth/user/recover-password",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                // beforeSend: function () {
                //     $('#forgotPassword').prop('disabled', true);
                //     $('#submit-button-loader').removeClass('d-none');
                //     $('#submit-icon').addClass('d-none');
                // },
                success: function (res) {
                    console.log(res)
                    if (res.status === "success") {
                        if (res.status === "success") {
                            toastr.success(res.message);
                            $("#changePassword").addClass('d-none')
                            $("#loginredirect").removeClass('d-none')
                        }
                        toastr.success(res.message);
                        // setInterval(() => {
                        //     window.location.href = "http://127.0.0.1:8000/login"
                        // }, 1000);

                    }
                    // setTimeout(location.reload.bind(location), 1000);
                },
                error: function (err) {
                    console.log("err", err.responseJSON);
                    var data = err.responseJSON
                    if (data.status === 'error') {
                        toastr.error(data.message);
                    } else if (data.status === "validate_error") {
                        toastr.error(data.data[0].error);
                    }
                }
            });
        });

    });

</script>

<script>
    let in1 = document.getElementById('otc-1'),
        ins = document.querySelectorAll('input[type="number"]'),
        splitNumber = function (e) {
            let data = e.data || e.target
                .value; // Chrome doesn't get the e.data, it's always empty, fallback to value then.
            if (!data) return; // Shouldn't happen, just in case.
            if (data.length === 1) return; // Here is a normal behavior, not a paste action.
            popuNext(e.target, data);
            //for (i = 0; i < data.length; i++ ) { ins[i].value = data[i]; }
        },
        popuNext = function (el, data) {
            el.value = data[0]; // Apply first item to first input
            data = data.substring(1); // remove the first char.
            if (el.nextElementSibling && data.length) {
                // Do the same with the next element and next data
                popuNext(el.nextElementSibling, data);
            }
        };
    ins.forEach(function (input) {
        input.addEventListener('keyup', function (e) {
            // Break if Shift, Tab, CMD, Option, Control.
            if (e.keyCode === 16 || e.keyCode == 9 || e.keyCode == 224 || e.keyCode == 18 || e
                .keyCode == 17) {
                return;
            }
            // On Backspace or left arrow, go to the previous field.
            if ((e.keyCode === 8 || e.keyCode === 37) && this.previousElementSibling && this
                .previousElementSibling.tagName === "INPUT") {
                this.previousElementSibling.select();
            } else if (e.keyCode !== 8 && this.nextElementSibling) {
                this.nextElementSibling.select();
            }
            // If the target is populated to quickly, value length can be > 1
            if (e.target.value.length > 1) {
                splitNumber(e);
            }
        });
        input.addEventListener('focus', function (e) {
            // If the focus element is the first one, do nothing
            if (this === in1) return;
            // If value of input 1 is empty, focus it.
            if (in1.value == '') {
                in1.focus();
            }
            // If value of a previous input is empty, focus it.
            // To remove if you don't wanna force user respecting the fields order.
            if (this.previousElementSibling.value == '') {
                this.previousElementSibling.focus();
            }
        });
    });
    in1.addEventListener('input', splitNumber);

</script>
@endpush
