<div class="modal-content">
    <div class="modal-title">
        <h4>Change Password</h4>
    </div>
    <form id="changePassForm" method="POST" enctype="multipart/form-data">

        <div class="form-group margin-top-40">
            <input name="old_password" type="text" class="form-control create-form" id="old" placeholder="Old Password">
        </div>

        <div class="form-group margin-top-40">
            <input name="password" type="text" class="form-control create-form" id="password" placeholder="New Password">
        </div>

        <div class="form-group margin-top-40">
            <input name="password_confirmation" type="text" class="form-control create-form" id="confirm" placeholder="Confirm Password">
        </div>

        <div class="actions margin-top-40">
            <button class="submit" type="submit" id="changePass">Change</button>
            <button type="button" class="cancel" data-dismiss="modal">Cancel</button>
        </div>
    </form>

</div>
<?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/settings/changePassword.blade.php ENDPATH**/ ?>