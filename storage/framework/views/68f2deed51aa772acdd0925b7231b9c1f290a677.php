<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/gijgo.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/filepond.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/filepond-plugin-image-preview.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/ckeditor.js')); ?>"></script>


<script src="<?php echo e(asset('assets/js/autoComplete.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/filepond.jquery.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/sweetalert2@11.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/iconify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/iconify-icon.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/toastr.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.serializejson.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/api.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/imageUpload.js')); ?>"></script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    var appId = localStorage.getItem("appId")
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function () {
        OneSignal.init({
            appId: appId,
        });
    });
</script>


<script>
    $('#close').click(function () {
        $('#sitebar').hide()
    })

    $('#sideBarHide').click(function () {
        $('#sitebar').toggle()
            if(!$('.main-body').hasClass('col-lg-12')){
                $('.main-body').addClass('col-lg-12')
            }else{
                $('.main-body').removeClass('col-lg-12')
            }
    })
</script>

<script type="text/javascript">
    $(window).load(function () { // makes sure the whole site is loaded
        $('#status').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(50).fadeOut(100); // will fade out the white DIV that covers the website.
        $('body').delay(50).css({'overflow': 'visible'});
    })
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            url: baseUrl + "/settings",
            type: "get",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.status === "success") {
                    $('.company-name').text(res.data.system_name || "")
                    $('.company-name').attr("href", window.origin)
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
            }
        }); //ajax
    });
</script>

<?php echo $__env->yieldPushContent("custom-js"); ?>
<?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/layouts/default/footerScript.blade.php ENDPATH**/ ?>