@extends('layouts.default.master')
@section('data_count')
{{-- Start:: content heading --}}
<style>
    .container {
        display: inline;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 18px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-left: 30px;
    }

    /* Hide the browser's default radio button */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>
<div class="modal-content mb-5">
    <div class="modal-title">
        <h4>Edit SMTP</h4>
    </div>
    <form id="smtpUpdateForm" method="POST" enctype="multipart/form-data" action="">
        @csrf
        <div class="form-group mt-5">
            <!-- <div class="smtp">
                <label for="huey">Smtp Type : </label>
                <label class="container">Gmail SMTP
                    <input type="radio" {{($target->name === "gmail") ? 'checked' : null}} name="smtp" value="gmail">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Server SMTP
                    <input type="radio" name="smtp" value="server" {{($target->name === "server") ? 'checked' : null}}>
                    <span class="checkmark"></span>
                </label>
            </div> -->
        </div>
        <div class="form-group">
            <label for="host">Host</label>
            <input class="form-control create-form" id="host" name="host" rows="0" placeholder="Write Here Title"
                value="{{$target->host}}">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="port">Port</label>
            <input class="form-control create-form" id="port" name="port" rows="0" placeholder="Write Here Title"
                value="{{$target->port}}">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="encryption">Encryption</label>
            <select name="encryption"  class="form-control create-form"  id="encryption">
                <option {{($target->encryption === "tls")?'selected':null }} value="tls">TLS</option>
                <option {{($target->encryption === "ssl")?'selected':null }} value="ssl">SSL</option>
            </select>
        </div>
        <div class="form-group">
            <label for="encription">Username</label>
            <input class="form-control create-form" id="username" name="username" rows="0"
                placeholder="Write Here Encription" value="{{$target->username}}">
            <span class="text-danger"></span>
        </div>
         <!-- <div class="form-group">
            <label for="encription">Email</label>
            <input class="form-control create-form" id="email" name="email" rows="0"
                placeholder="Write Here Encription" value="{{$target->email}}">
            <span class="text-danger"></span>
        </div> -->
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control create-form" id="password" name="password" rows="0"
                placeholder="Write Here Passsword" value="{{$target->password}}">
            <span class="text-danger"></span>
        </div>
        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="updateSmtp">Update</button>
            <a href="/admin/dashboard">Cancel</a>
        </div>
    </form>
    <div class="smtp-note d-flex align-items-center">
        <div class="icon">
            <iconify-icon icon="carbon:notification-off-filled"></iconify-icon>
        </div>
        <div class="text">
            <p> <span class="fw-bold">Note:</span> <br> SMTP Configuration is required otherwise <span class="fw-bold">Forgot Password</span> or <span class="fw-bold">Email feature</span> won’t work.</p>
        </div>
    </div>
</div>

@stop
@push('custom-js')

<script>
    $(function () {
        //category save
        $(document).on("click", "#updateSmtp", function (e) {
            e.preventDefault();
            // alert($('#description').val());
            var formData = new FormData($('#smtpUpdateForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $("#preloader").removeClass('d-none');
            $.ajax({
                url: baseUrl+"/admin/smtp/update",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function (res) {
                    toastr.success('SMTP Create successfully', res, options);
                    setTimeout(location.reload.bind(location), 1000);

                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if(jqXhr.status == 422 &&  jqXhr.responseJSON.status == "error"){
                        toastr.error(jqXhr.responseJSON.message);
                        $("#preloader").addClass('d-none');
                    }

                }
            });
        });
    });
    //category edit Modal

</script>
@endpush
