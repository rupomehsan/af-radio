@extends('layouts.default.master')
@section('data_count')

    {{-- Start:: content heading --}}
    <div class="content-heading">
        <div class="row">
            {{-- title --}}
            <div class="col-md-8 content-title">
                <span class="title">Station</span>
                <button type="button" class="create-button pannel-status " data-toggle="modal" data-target="#crateModal"
                        id="crateBtn">
                    <span class="iconify" data-icon="bi:plus-circle-fill"></span>Add Station
                </button>
                <div class="title-line"></div>
                <!-- Button trigger modal -->
            </div>
            {{-- title --}}
            {{-- search --}}
            <div class="col-md-4 text-right pannel-status">
                <form action="/admin/country/filter" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group content-search">
                        <button class="input-group-text search" id="addon-wrapping">
                            <span class="iconify" data-icon="bx:bx-search"></span>
                        </button>
                        <input name="fil_search" type="text" class="form-control search" placeholder="Search"
                               aria-label="fil_search">
                    </div>
                </form>
            </div>
            {{-- search --}}
        </div>
    </div>
    {{-- End:: content heading --}}


    {{-- Start::Content Body --}}
    <div class="pannel-status">
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
        <div class="row">
            @if (!$target->isEmpty())
                @foreach ($target as $data)
                    <div class="col-md-4 single-content margin-top-40">
                        <div class="single-content-wraper margin-top-20">
                            @if (!empty($data->image))
                                <img src="{{ $data->image }}" alt="{{ $data->name }}"
                                     title="{{ $data->name }}"/>
                            @else
                                <img src="{{ asset('assets/img/dummy.jpg')}}" alt=""/>
                            @endif
                            <div class="total-videos margin-top-20">
                                <p class="cat-title">{{ $data->name }}</p>
                                <div class="switch">
                                    <label class="">
                                        <input type="checkbox" id="approval" data-id="{{$data->id}}" type="checkbox"
                                               @if($data->status=="active") ? checked : @endif>>
                                        <div class="slider round"></div>
                                    </label>
                                </div>

                                <div class="content-actions margin-top-20">
                                    <button title="Edit" type="button" data-toggle="modal" data-target="#crateModal"
                                            id="editBtn"
                                            data-id="{{ $data->id }}"><span class="iconify"
                                                                            data-icon="ant-design:edit-filled"></span>
                                        Edit
                                    </button>&nbsp;&nbsp;
                                    {{-- <button class="delete tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete"> --}}
                                    <button class="deleteBtn" data-id="{{ $data->id }}" title="Delete" id="">
                                        <span class="iconify" data-icon="ant-design:delete-filled"></span>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-6">
                    <h5 class="alert alert-warning">Station Not Create Yet..</h5>
                </div>
            @endif
                <nav class="page-navigation d-flex justify-content-center py-3 ">
                    {{$target->links()}}
                </nav>
        </div>
    </div>
    {{-- End::Content Body --}}

    {{-- create modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="crateModal">
        <div class="modal-dialog modal-lg">
            <div id="showCreateModal">

            </div>
        </div>
    </div>


@stop
@push('custom-js')
    <script type="text/javascript">
        $(function () {
            //pannel status
            $(document).on("change", "#approval", function (e) {
                e.preventDefault();
                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null
                };
                var id = $(this).data('id');
                // alert(id);

                if ($(this).prop('checked')) {
                    var properties = 'active'
                    // alert(properties)
                } else {
                    var properties = 'inactive'
                    //  alert(properties)
                }
                $("#preloader").removeClass('d-none');
                $.ajax({
                    url: baseUrl + "/admin/manage-countryApproval",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        status: properties,
                    },
                    success: function (res) {
                        console.log(res.success)
                        if (res) {
                            toastr.success('Successfully Update',);
                            $("#preloader").addClass('d-none');

                        }
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 422 && jqXhr.responseJSON.status == "error") {
                            toastr.error(jqXhr.responseJSON.message)
                            $("#preloader").addClass('d-none');
                        }
                    }
                }); //ajax
            });
            $(document).on("change", "#pannelStatus", function (e) {
                e.preventDefault();
                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null
                };
                var name = $(this).data('id');
                // alert(name);

                if ($(this).prop('checked')) {
                    var properties = 'on'
                    $(".pannel-status").show();
                } else {
                    var properties = 'off'
                    $(".pannel-status").hide();
                }
                $.ajax({
                    url: baseUrl + "/management-status",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        name: name,
                        status: properties,
                    }
                }); //ajax
            });
            // create Modal
            $(document).on("click", "#crateBtn", function (e) {
                e.preventDefault();
                $.ajax({
                    url: baseUrl + "/admin/country/create",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        $("#showCreateModal").html(res.html);
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                    }
                }); //ajax
            });
            // edit Modal
            $(document).on("click", "#editBtn", function (e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                $.ajax({
                    url: baseUrl + "/admin/country/edit",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                    },
                    success: function (res) {
                        $("#showCreateModal").html(res.html);
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                    }
                }); //ajax
            });
            // save
            $(document).on("click", "#createCountry", function (e) {
                e.preventDefault();
                var formData = new FormData($('#countryCreateForm')[0]);

                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null
                };
                $.ajax({
                    url: baseUrl + "/admin/country/store",
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    beforeSend: function () {
                        $('#preloader').removeClass('d-none')
                    },
                    success: function (res) {
                        toastr.success('Station Added successfully', res, options);
                        setTimeout(location.reload.bind(location), 1000);
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 422) {
                            $("#preloader").addClass('d-none');
                            if (jqXhr.status == 422 && jqXhr.responseJSON.status == "error") {
                                toastr.error(jqXhr.responseJSON.message);
                            }
                            var errorsHtml = '';
                            var errors = jqXhr.responseJSON.message;
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
                        App.unblockUI();
                    }
                });
            });
            // edit
            $(document).on("click", "#editCountry", function (e) {
                e.preventDefault();
                var formData = new FormData($('#countryEditForm')[0]);

                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null
                };
                $("#preloader").removeClass('d-none');
                $.ajax({
                    url: baseUrl + "/admin/country/update",
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function (res) {
                        toastr.success('Station updated successfully', res, options);
                        setTimeout(location.reload.bind(location), 1000);
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 422) {
                            $("#preloader").addClass('d-none');
                            if (jqXhr.status == 422 && jqXhr.responseJSON.status == "error") {
                                toastr.error(jqXhr.responseJSON.message);
                            }
                            var errorsHtml = '';
                            var errors = jqXhr.responseJSON.message;
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
                        App.unblockUI();
                    }
                });
            });
        });
        $(document).on("change", ".file-uploader", function (e) {
            e.preventDefault();
            var file = e.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'country');
            var showurl = window.origin + '/admin/country/file-upload';
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
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                        $("#preloader").addClass('d-none');
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


        $(document).on("click", ".deleteBtn", function () {
            let dataId = $(this).attr("data-id")
            let url = baseUrl + "/admin/country/" + dataId
            deleteItem(url)

            function deleteItem(url) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (res) {
                                if (res.status === "success") {
                                    Swal.fire(
                                        "Deleted!",
                                        "Your file has been deleted.",
                                        "success"
                                    );
                                    setTimeout(reload, 1000)

                                    function reload() {
                                        location.reload()
                                    }
                                }

                            },
                            error: function (xhr, resp, text) {
                                console.log(xhr);
                                // on error, tell the failed
                            },
                        });
                    }
                });
            }
        })

    </script>
@endpush
