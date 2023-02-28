<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>"/>
    <script src="<?php echo e(asset('assets/js/bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <title>Success</title>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>


    <div class="row justify-content-center mt-5 mx-3">
        <div class="col-12 col-md-4 ">
            <div class="alert alert-success d-flex align-items-center justify-content-center py-5 mt-5   w-100 m-auto "
                 role="alert">
                <svg class="bi flex-shrink-0 me-2" width="34" height="34" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
                <div>
                    Payment Success
                </div>
            </div>
        </div>
    </div>

</head>
<body>
<script>
    $(function () {
        var response = "<?php echo e(request()->segment(2)); ?>"
        var type = "<?php echo e(request()->segment(1)); ?>"

        var url = window.location.href
        // alert(url)
        if (type === "paypal") {
            if (response === "success") {
                let getData = url.split("?")
                let getData2 = getData[1].split("&")
                let token = getData2[0].replace('token=', "")
                let payerId = getData2[1].replace('PayerID=', "")
                $.ajax({
                    url: window.origin + "/api/v1/paypal-check-order-status",
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"token": token, "payerId": payerId},
                    success: function (res) {
                        console.log(res)
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })

            }
        } else if (type === "stripe") {
            if (response === "success") {
                let getData = url.split("?")
                let token = getData[1].replace('uuid=', "")
                $.ajax({
                    url: window.origin + "/api/v1/stripe-check-pre-payment-token",
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"token": token},
                    success: function (res) {
                        if (res.status === "success") {
                            let session_id = res.data.order_id
                            let user_id = res.data.user_id
                            $.ajax({
                                url: window.origin + "/api/v1/stripe-check-order-status",
                                method: "post",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {"session_id": session_id,"user_id":user_id},
                                success: function (res) {
                                    console.log(res)
                                },
                                error: function (err) {
                                    console.log(err)
                                }
                            })
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })

            }
        }

    })
</script>
</body>
</html>
<?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/payment/success.blade.php ENDPATH**/ ?>