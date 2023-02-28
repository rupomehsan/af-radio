<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 col-sm-6 content-title">
                <span class="title">Notification</span>
                <button type="button" class="create-button" data-toggle="modal" data-target="#crateModal"
                        id="notificationCreate"></button>
                <div class="title-line"></div>
            </div>
            
            
            <div class="col-md-4 col-sm-6 text-right">
                <a href="/admin/notification/manage-notification" class="btn btn-outline-dark btn-sm">
                    Manage Notification <span class="iconify"  data-icon="akar-icons:arrow-back-thick"></span>
                </a>
            </div>
            
        </div>
        <div class="content-heading mt-2">
            <div class="row justify-content-between align-items-center border">
                
                <div class="col-4 col-sm-6 col-md-6 col-lg-7 col-xl-6">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-4">
                            <a href="/admin/notification" class="font-weight-bold text-dark">Immediate Push</a>
                        </div>
                        <div class="col-md-4 d-flex ">
                            <a href="/admin/notification/schedule" class="font-weight-bold ">Schedule Push</a>
                        </div>
                        <div class="col-md-4 d-flex ">
                            <a href="/admin/notification/linked" class="font-weight-bold text-dark">Linked Push</a>
                        </div>
                    </div>
                </div>

                <div class="col-8 col-sm-6 col-md-6 col-lg-4 col-xl-2 d-flex align-items-center justify-content-md-end my-1">
                    <div class="dropdown ml-auto">
                        <button class="btn border border-dark dropdown-toggle d-flex align-items-center" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <iconify-icon icon="akar-icons:filter" style="color: black;margin-right: 5px;" width="20"
                                          height="20"></iconify-icon>
                            Filter
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('today')">Today</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_day')">Last Day</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_week')">Last Week</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_month')">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_year')">Last Year</a>
                        </div>
                    </div>
                    <div class="addItemBtn ml-1">
                        <button type="button" class=" btn btn-dark" data-toggle="modal" data-target="#crateModal"
                                id="notificationCreate"><span class="iconify mx-1" data-icon="bi:plus-circle-fill" ></span>Add
                            Notification</button>
                        <div class="title-line"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    

    
    <?php
    $ses_msg = Session::has('success');
    if (!empty($ses_msg)) {
    ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('success'); ?></p>
    </div>
    <?php
    }//
    $ses_msg = Session::has('error');
    if (!empty($ses_msg)) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('error'); ?></p>
    </div>
    <?php
    }// ?>
    <div class="row margin-top-40 content-details">
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="text-center">SERIAL</th>
                <th scope="col" class="text-center">TITLE</th>
                <th scope="col" class="text-center">DESCRIPTION</th>
                <th scope="col" class="text-center text-uppercase"> Created Date</th>
                <th scope="col" class="text-center text-uppercase"> Schedule Date</th>
                <th scope="col" class="text-center">ACTIONS</th>
            </tr>
            </thead>
            <tbody id="tableBody">

            <?php $sl = 1; ?>
            <?php if(!$target->isEmpty()): ?>

                <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th class="text-center"><?php echo e($sl++); ?></th>
                        <td class="text-center"><?php echo $data->title ?? ''; ?></td>
                        <td class="text-center"><?php echo e($data->description ?? ''); ?></td>
                        <td class="text-center"><?php echo e($data->created_at->isoFormat('Do MMMM YYYY')); ?></td>
                        <td class="text-center"><?php echo e($data->end_date); ?></td>
                        <td class="table-actions text-center">

                            <button type="submit" class="" onclick="deleteItem('<?php echo e(URL::to('/admin/notification/' . $data->id)); ?>')" title="Delete"> <iconify-icon icon="ant-design:delete-filled"
                                                                                                                                                                                style="color: #063288;margin: 0px 5px;"></iconify-icon> DELETE</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            </tbody>
        </table>
        <nav class="page-navigation d-flex justify-content-center py-3 ">
            <?php echo e($target->links()); ?>

        </nav>
    </div>
    

    
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="crateModal">
        <div class="modal-dialog modal-lg">
            <div id="showCreateModal">

            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        // create notification modal
        var pageName = "<?php echo e(request()->segment(3)); ?>"

        $(document).on("click", "#notificationCreate", function(e) {
            e.preventDefault();
            $.ajax({
                url: baseUrl+"/admin/notification/create",
                type: "POST",
                dataType: "json",
                beforeSend: function () {
                    $("#preloader").removeClass('d-none');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    $("#showCreateModal").html(res.html);
                    if(pageName){
                        $("#type").val('schedule')
                    }
                    $(".schedule").removeClass("d-none")
                    // $('#schedule_date').datetimepicker('show');
                    $('#schedule_date').datetimepicker({ footer: true, modal: true });
                },
                error: function(jqXhr, ajaxOptions, thrownError) {},
                complete:function (){
                    $("#preloader").addClass('d-none');
                }
            }); //ajax

        });


        // save
        $(document).on("click", "#createNotification", function(e) {
            e.preventDefault();
            var formData = new FormData($('#notificationCreateForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };

            $.ajax({
                url: rootUrl+"send-notification",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {
                    $("#preloader").removeClass('d-none');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    toastr.success('Notification Create successfully', res, options);
                    setTimeout(location.reload.bind(location), 1000);
                },
                error: function(jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 422) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 500) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    App.unblockUI();
                },
                complete: function () {
                    $("#preloader").addClass('d-none');
                },
            });
        });

        $(document).on("change", ".file-uploader", function(e) {
            e.preventDefault();
            var file = e.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'radio');
            var showurl = window.origin + '/admin/radio/file-upload';
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };


            $("#preloader").removeClass('d-none');
            $.ajax({
                url: showurl,
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization' : localStorage.getItem('token'),
                },
                data: formData,
                success: function(res) {
                    toastr.success('File Upload successfully');
                    $("#imageUrl").val(res.data);
                    $("#preloader").addClass('d-none');
                },
                error: function(jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 422) {
                        $("#preloader").addClass('d-none');
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 404) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                        $("#preloader").addClass('d-none');
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                        $("#preloader").addClass('d-none');
                    }
                }
            });
        });


        function getSearchData(data) {

            $.ajax({
                method: "get",
                url: rootUrl + "get_immediate_schedule_search_data",
                dataType: "json",
                data: {"value": data, "type": "schedule"},
                success: function (response) {
                    if (response.status === 'success') {
                        appendTableData(response)
                    }
                },
                error: function (err) {
                    console.log(err)
                },

            });
        }


        function appendTableData(response) {
            $("#tableBody").empty()
            response.data.forEach((item, index) => {
                $("#tableBody").empty()
                $("#tableBody").append(`
                                   <tr>
                            <th class="text-center">${index + 1}</th>
                            <td class="text-center">${item.title}</td>
                            <td class="text-center">${item.description}</td>
                            <td class="text-center">${new Date(item.created_at).toLocaleString('en-us',{month:'long', year:'numeric',day:'numeric'})}</td>
                            <td class="text-center">${item.end_date}</td>
                            <td class="table-actions text-center">
<!--                                 <button type="submit" class="" onclick="deleteItem('${baseUrl}/admin/notification/${item.id}')" title="Delete"><iconify-icon icon="bi:send-x-fill"></iconify-icon> Resend</button>-->
                                <button type="submit" class="" onclick="deleteItem('${baseUrl}/admin/notification/${item.id}')" title="Delete"> <iconify-icon icon="ant-design:delete-filled"
                                                                                                                                                                                 style="color: #063288;margin: 0px 5px;"></iconify-icon> DELETE</button>
                            </td>
                        </tr>

                          `)

            })
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/notification/schedule.blade.php ENDPATH**/ ?>