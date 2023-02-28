<div class="modal-content">
    <div class="modal-title">
        <h4>Edit Station</h4>
    </div>
    <form id="countryEditForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo e($target->id); ?>">
        <div class="form-group margin-top-40">
            <input name="name" type="text" class="form-control create-form" id="name" placeholder="Station Name" value="<?php echo e($target->name); ?>">
        </div>

        <div class="file-upload-edit">
                <div class="image-upload-wrap-edit">
                    <input type="hidden" name="imageEdit" id="imageUrl">
                    <input value="" name="image" class="file-upload-input-edit file-uploader" type='file' onchange="readURLEdit(this);" accept="image/*" />
                    <div class="drag-text-edit text-center">
                        <span class="iconify" data-icon="bx:bx-image-alt"></span> <br>
                        <span>Upload Image Or Drag Here</span>
                    </div>
                </div>
                <div class="file-upload-content-edit">
                    <img class="file-upload-image-edit" src="<?php echo e($target->image ?? asset('assets/img/dummy.jpg')); ?>" alt="<?php echo e($target->name); ?>" />
                    <div class="image-title-wrap-edit">
                        <button type="button" onclick="removeUploadEdit()" class="remove-image-edit">
                            <span class="iconify" data-icon="akar-icons:cross"></span>
                        </button>
                    </div>
                </div>
            </div>

        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="editCountry">Update</button>
            <button type="button" class="cancel" data-dismiss="modal">Cancel</button>
        </div>
    </form>

</div>
<?php /**PATH /home/ccninfot/afradio.ccninfotech.com/resources/views/country/edit.blade.php ENDPATH**/ ?>