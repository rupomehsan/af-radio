<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <div class="row">

                    <div class="col-md-2">
                        <span class="title">Subscription</span>
                        <div class="title-line"></div>
                    </div>
                    <div class="col-md-2">
                        <span class="sub-title">
                            <a href="/admin/subscription/all-package" class="title-btn">Package</a>
                        </span>
                        <div class="title-line sub-category-title-line display-none"></div>
                    </div>

                </div>
            </div>
            

            
            
            
        </div>
    </div>
    

    
    <div class="row margin-top-40 content-details">

        <table class="table">
            <thead class="thead-light">
                <tr class="table-head">
                    <th scope="col" class="text-center">Serial</th>
                    <th scope="col" class="text-center">Subscriber Email</th>
                    <th scope="col" class="text-center">Pakage Name</th>
                    <th scope="col" class="text-center">Subscription Date</th>
                    
                </tr>
            </thead>
            <tbody id="tableContent">
            </tbody>
        </table>
    </div>
    


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(function() {
            // index data
            $(document).ready(function() {
                var sl = 1;
                var showurl = window.origin + '/api/v1/subscription/get-all';
                $.ajax({
                    url: showurl,
                    type: "get",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': localStorage.getItem('token'),
                    },
                    success: function(res) {
                        console.log(res)
                        if(res.status === 'success'){
                            res.data.forEach(function(item, i) {
                                $("#tableContent").append(`
                                    <tr>
                                        <th class="text-center" scope="row">${i + 1}</th>
                                        <td class="text-center">${item?.user?.email ? item?.user?.email : ''}</td>
                                        <td class="text-center">${item.packageName ? item.packageName : ''}</td>
                                        <td class="text-center">${item.added_on ? item.added_on : ''}</td>
                                    </tr>
                                `);
                            });
                        }

                    },
                    error: function(jqXhr, ajaxOptions, thrownError) {}
                }); //ajax
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/subscription/index.blade.php ENDPATH**/ ?>