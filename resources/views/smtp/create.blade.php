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
        <h4>Add SMTP</h4>
    </div>
    <form id="smtpCreateForm" method="POST" enctype="multipart/form-data" action="">
        @csrf
        <!-- <div class="mt-5">
                <label for="huey">Smtp Type : </label>
                <label class="container">Gmail SMTP
                    <input type="radio" name="smtp" value="gmail">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Server SMTP
                    <input type="radio" name="smtp" value="server">
                    <span class="checkmark"></span>
                </label>
            </div> -->
        <div class="form-group">
            <label for="host">Host </label>
            <input class="form-control create-form" id="host" name="host" rows="0" placeholder="Write Here Title">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="port">Port</label>
            <input class="form-control create-form" id="port" name="port" rows="0" placeholder="Write Here Title">
            <span class="text-danger"></span>
        </div>

        <div class="form-group">
            <label for="encryption">Encryption</label>
            <input type="text" class="form-control create-form" id="encryption" name="encryption" rows="0"
                placeholder="Write Here Encryption">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="encription">Username</label>
            <input class="form-control create-form" id="username" name="username" rows="0"
                placeholder="Write Here Encription">
            <span class="text-danger"></span>
        </div>


        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control create-form" id="password" name="password" rows="0"
                placeholder="Write Here Passsword">
            <span class="text-danger"></span>
        </div>

        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="createSmtp">Save</button>
            <button type="button" class="cancel" data-dismiss="modal">Cancel</button>
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
        $(document).on("click", "#createSmtp", function (e) {
            e.preventDefault();
            // alert($('#description').val());
            var formData = new FormData($('#smtpCreateForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: baseUrl+"/admin/smtp/store",
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
                    if (jqXhr.status == 422) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 500) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                }
            });
        });
    });
    //category edit Modal

</script>
@endpush
