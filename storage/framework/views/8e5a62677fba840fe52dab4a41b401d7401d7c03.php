<?php $__env->startSection('data_count'); ?>
    
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
        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked ~ .checkmark:after {
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
    <div class="col-md-8 content-title mb-3">
        <span class="title bold">Payment Settings</span>
        <button type="button" class="create-button" data-toggle="modal" data-target="#crateModal"
                id="notificationCreate"></button>
        <div class="title-line"></div>
    </div>
    <div class="modal-content mb-5">


        <form id="smtpCreateForm" method="POST" enctype="multipart/form-data" action="">

            <div class="content-title mb-3">
                <span class="title">Paypal</span>
                <div class="title-line"></div>
            </div>
            <div class="form-group">
                <label for="host">Paypal Client Id </label>
                <input class="form-control create-form" id="host" name="paypal_client_id"
                       placeholder="Paypal Client Id">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="port">Paypal Secret Key</label>
                <input class="form-control create-form" id="port" name="paypal_secret_key"
                       placeholder="Paypal Secret Key">
                <span class="text-danger"></span>
            </div>
            <div class="content-title mb-3">
                <span class="title">Stripe</span>
                <div class="title-line"></div>
            </div>
            <div class="form-group">
                <label for="encryption">Stripe Publishable Key</label>
                <input type="text" class="form-control create-form" id="encryption" name="stripe_publishable_key"
                       placeholder="Stripe Publishable Key">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="encription">Stripe Secret Key</label>
                <input class="form-control create-form" id="username" name="stripe_secret_key"
                       placeholder="Stripe Secret Key">
                <span class="text-danger"></span>
            </div>
            <div class="content-title mb-3">
                <span class="title">Wyer</span>
                <div class="title-line"></div>
            </div>

            <div class="form-group">
                <label for="password">Wyer Client Id </label>
                <input type="text" class="form-control create-form" id="password" name="wyre_client_id"
                       placeholder="Wyer Client Id">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Wyer Secret Key</label>
                <input type="text" class="form-control create-form" id="password" name="wyre_secret_key"
                       placeholder="Wyer Secret Key">
                <span class="text-danger"></span>
            </div>

            <div class="actions margin-top-40">
                <button class="submit" type="submit" id="createSmtp">Save</button>
            </div>
        </form>
        <div class="smtp-note d-flex align-items-center">
            <div class="icon">
                <iconify-icon icon="carbon:notification-off-filled"></iconify-icon>
            </div>
            <div class="text">
                <p><span class="fw-bold">Note:</span> <br>This data is required otherwise <b> Payment </b>feature would
                    not work .</p>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script>
        $(function () {
            getPayment()


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
                    url: rootUrl+"payment_settings_store",
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function (res) {
                        toastr.success(res.message);
                        setTimeout(location.reload.bind(location), 1000);
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {

                    }
                });
            });

        });

        function getPayment(){
            $.ajax({
                url: rootUrl+"payment_settings_get",
                type: 'get',
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                  if(res.status==="success"){
                      $("#createSmtp").text("Update")
                      Object.entries(res.data).forEach((item) => {
                          // console.log(item)
                          $(`input[name=${item[0]}`).val(item[1])
                      })
                  }
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                  console.log(jqXhr)
                }
            });
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/payment/create.blade.php ENDPATH**/ ?>