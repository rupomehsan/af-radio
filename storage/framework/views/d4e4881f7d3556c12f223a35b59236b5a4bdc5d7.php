<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <div class="row">
                    <div class="col-md-2">
                        <span class="sub-title">
                            <a href="/admin/subscription" class="title-btn" id="subCategory">Subscription</a>
                        </span>
                        <div class="title-line sub-category-title-line display-none"></div>
                    </div>

                    <div class="col-md-2">
                        <span class="title">Package</span>
                        <div class="title-line"></div>
                    </div>

                </div>
            </div>
            

            
            
            
        </div>
    </div>
    

    
    <div class="row margin-top-40 content-details">

        <table class="table">
            <thead class="thead-light">
                <tr  class="table-head">
                    <th scope="col" class="text-center">Serial</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Price</th>
                    <th scope="col" class="text-center">description</th>
                    
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
                var showurl = window.origin + '/api/v1/subscription/package/get-all';
                $.ajax({
                    url: showurl,
                    type: "get",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': localStorage.getItem('token'),
                    },
                    success: function(res) {
                        res.data.forEach(function(item) {
                            $("#tableContent").append(`
                        <tr>
                            <th class="text-center" scope="row">${sl}</th>
                            <td class="text-center">${item.name ? item.name : ''}</td>
                            <td class="text-center">${item.price ? item.price : ''}</td>
                            <td class="text-center">${item.description ? item.description : ''}</td>
                        </tr>
                    `);
                            sl++;
                        });
                    },
                    error: function(jqXhr, ajaxOptions, thrownError) {}
                }); //ajax
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/subscription/packageIndex.blade.php ENDPATH**/ ?>