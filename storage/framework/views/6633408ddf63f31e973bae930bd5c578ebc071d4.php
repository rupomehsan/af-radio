<?php $__env->startSection('data_count'); ?>
    
    <div class="modal-content mb-5">
        <div class="modal-title">
            <h4>Add Radio</h4>
        </div>
        <form id="radioCreateForm" method="POST" enctype="multipart/form-data" action="">
            <?php echo csrf_field(); ?>
            <div class="form-group margin-top-40" style="position: relative">
                <label for="language_id">Language</label>
                <i class="fas fa-sort-down"></i>
                <select name="language_id" id="language_id" class="form-control create-form">
                    <option selected disabled>Select Language</option>
                    <?php if(!empty($languages)): ?>
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                
            </div>

            <div class="form-group margin-top-40" style="position: relative">
                <label for="language_id">Station</label>
                <i class="fas fa-sort-down"></i>
                <select name="station_id" id="station_id" class="form-control create-form">
                    <option selected disabled>Select Station</option>
                    <?php if(!empty($countries)): ?>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($country); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                
            </div>
            <div class="form-group margin-top-40" style="position: relative">
                <label for="category">Category</label>
                <i class="fas fa-sort-down"></i>
                <select name="category" id="category" class="form-control create-form">
                    <option selected disabled>Select Category</option>
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
                
            </div>

            <div class="form-group">
                <label for="title">Radio Name </label>
                <input class="form-control create-form" id="radio_name" name="radio_name" rows="0"
                       placeholder="Write Here Title">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="title">Radio Frequency</label>
                <input class="form-control create-form" id="title" name="radio_frequency" rows="0"
                       placeholder="Write Here Title">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="title">Radio Url</label>
                <input class="form-control create-form" id="title" name="radio_url" rows="0"
                       placeholder="Write Here Title">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="description">Radio Description</label>
                
                <textarea class="form-control create-form" id="content" name="description" rows="10"
                          placeholder="Write Here Description"></textarea>
                <span class="text-danger"></span>
                
            </div>

            <div class="col-md-6">
                <div class="image" id="image">
                    <label for="image">Select Image</label>
                    <div class="file-upload">
                        <div class="image-upload-wrap">
                            <input type="hidden" name="image" id="imageUrl">
                            <input id="image" class="file-upload-input file-uploader" type='file'
                                   onchange="readURL(this);"
                                   accept="image/*"/>
                            <div class="drag-text text-center">
                                <span class="iconify" data-icon="teenyicons:user-square-outline"></span> <br>
                                <span>Upload Image Or Drag Here</span>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image"/>
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">
                                    <span class="iconify" data-icon="akar-icons:cross"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions margin-top-40">
                <button class="submit" type="submit" id="createRadio">Add Radio</button>
                <a href="/admin/radio">Cancel</a>
            </div>
        </form>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script>
        ClassicEditor.create(document.querySelector('#content'), {
        }).then( editor => {
            window.editor = editor;
            // Prevent showing a warning notification when user is pasting a content from MS Word or Google Docs.
            window.preventPasteFromOfficeNotification = true;

            document.querySelector( '.ck.ck-editor__main' );
        } )
            .catch(error => {
                console.error(error);
            });
        $(function () {
            //category save
            $(document).on("click", "#createRadio", function (e) {
                e.preventDefault();
                // alert($('#description').val());

                var formData = new FormData($('#radioCreateForm')[0]);
                formData.append('description', $('.ck-content').text());

                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null
                };
                $("#preloader").removeClass('d-none');
                $.ajax({
                    url: baseUrl + "/admin/radio/store",
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function (res) {
                        toastr.success('Radio Create successfully', res, options);
                        window.location.href = "<?php echo e(url('admin/radio')); ?>"
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        console.log(jqXhr)
                        if (jqXhr.status == 422) {
                            $("#preloader").addClass('d-none');
                            var errors = jqXhr.responseJSON.message;
                            if (jqXhr.status == 422 && jqXhr.responseJSON.status == "error") {
                                toastr.error(jqXhr.responseJSON.message);
                            }
                            var errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                        } else if (jqXhr.status == 500) {
                            toastr.error(jqXhr.responseJSON.message, '', options);
                            $("#preloader").addClass('d-none');
                        } else {
                            toastr.error('Error', 'Something went wrong', options);
                            $("#preloader").addClass('d-none');
                        }
                    }
                });
            });

        });
        //ck text editor


        // ClassicEditor.create(document.querySelector("#description"))
        //     .then((editor) => {
        //         faqEditor = editor;
        //         console.log(faqEditor);
        //     })

        //  let descriptionEditor;
        //   ClassicEditor.create(document.querySelector('#content'))
        //     .catch(error => {
        //             console.error(error);
        //         });
        $(document).on("change", ".file-uploader", function (e) {
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
                    'Authorization': localStorage.getItem('token'),
                },
                data: formData,
                success: function (res) {
                    toastr.success('File Upload successfully');
                    $("#imageUrl").val(res.data);
                    $("#preloader").addClass('d-none');
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 422) {
                        $("#preloader").addClass('d-none');
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
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

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/radio/create.blade.php ENDPATH**/ ?>