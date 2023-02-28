
<form method="POST" enctype="multipart/form-data"
      action="{{ URL::to('admin/notification/manage-notification-update') }}">
    @csrf
    <input name="notification_type" type="hidden" value="mobile">


    <div class="row notification-manage-content-mobile">
        <div class="col-md-10">
            <div class="form-group margin-top-40">
                <label for="mobileApiKey">OneSignal Api Key</label>
                <input name="mobile_api_key" type="text" class="form-control create-form" id="mobileApiKey"
                       placeholder="Api key" value="{!! $target->api_key ?? ''!!}">
                <span class="text-danger">{{ $errors->first('mobile_api_key') }}</span>
            </div>
        </div>

        <div class="col-md-10">
            <div class="form-group margin-top-40">
                <label for="mobileApiId">OneSignal Api ID</label>
                <input name="mobile_api_id" type="text" class="form-control create-form" id="mobileApiId"
                       placeholder="Api ID" value="{!! $target->api_id ?? ''!!}">
                <span class="text-danger">{{ $errors->first('mobile_api_id') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-12 actions margin-top-10">
        <button type="submit" class="submit">Save</button>
    </div>
</form>
