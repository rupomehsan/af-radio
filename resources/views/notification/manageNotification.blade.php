@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
    <div class="content-heading">
        <div class="row">
            {{-- title --}}
            <div class="col-md-8 content-title">
                <span class="title">Manage Notification</span>
                <div class="title-line"></div>
            </div>
            {{-- title --}}
            {{-- search --}}
            <div class="col-md-4 text-right">
                {{-- <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#xlModal"
                    id="manageNotification">
                    Manage Notification
                </button> --}}

                <a href="/admin/notification" class="btn btn-outline-dark btn-sm"><span class="iconify"
                                                                                        data-icon="akar-icons:arrow-back-thick"></span>&nbsp; Back Notification</a>

            </div>
            {{-- search --}}

        </div>
    </div>
    {{-- End:: content heading --}}

    {{-- Start::Content Body --}}
    <div class="row margin-top-40 create-body content-details">

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

        {{-- Start:: Mobile Notification --}}
        <div class="col-md-6 for-mobile" id="showMobileNotification">
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
        </div>
        {{-- End:: Mobile Notification --}}



    </div>
    {{-- End::Content Body --}}


@stop
@push('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: window.origin+"/admin/notification/manage-notification/get-mobile-data",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    notification_type: 'mobile'
                },
                success: function(res) {
                    console.log("dataa",res)
                    $("#mobileApiKey").val(res.data.api_key)
                    $("#mobileApiId").val(res.data.api_id)
                    localStorage.setItem("appId",res.data.api_id)

                },
                error: function(jqXhr, ajaxOptions, thrownError) {}
            }); //ajax

        });
    </script>
@endpush
