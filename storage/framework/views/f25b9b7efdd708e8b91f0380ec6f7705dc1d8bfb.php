



<div class="modal-content">
    <div class="modal-title">
        <h4>Add Notification</h4>
    </div>
    <form id="notificationCreateForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" id="type" value="immediate">
        <div class="form-group margin-top-40">
            <input type="text" name="title" class="form-control create-form" id="title" placeholder="Notification title">
        </div>
        <div class="form-group margin-top-40">
            <textarea type="text" rows="5" cols="10" name="description" class="form-control " id="description" placeholder="Notification description"></textarea>
        </div>

        <div class="form-group margin-top-40 d-none schedule">


            <input class="form-control create-form" name="schedule_date" id="schedule_date">
        </div>

        <div class="form-group margin-top-40 d-none link-notif">
            <input name="external_link" type="text" class="form-control create-form" id="externalurl" placeholder="External link">
        </div>

        <div class="file-upload">
            <div class="image-upload-wrap">
                <input type="hidden" name="image" id="imageUrl">
                <input id="image" class="file-upload-input file-uploader" type='file' onchange="readURL(this);"
                       accept="image/*" />
                <div class="drag-text text-center">
                    <span class="iconify" data-icon="teenyicons:user-square-outline"></span> <br>
                    <span>Upload Image Or Drag Here</span>
                </div>
            </div>
            <div class="file-upload-content">
                <img class="file-upload-image" src="#" alt="your image" />
                <div class="image-title-wrap">
                    <button type="button" onclick="removeUpload()" class="remove-image">
                        <span class="iconify" data-icon="akar-icons:cross"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="createNotification">Add Notification</button>
            <button type="button" class="cancel" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
<?php /**PATH /home/ccninfot/afradio.ccninfotech.com/resources/views/notification/create.blade.php ENDPATH**/ ?>