@extends('layouts.default.master')
@section('data_count')
{{-- Start::Content Body --}} <?php
$ses_msg = Session::has('msg');
if (!empty($ses_msg)) {
    ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('msg'); ?></p>
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
<!-- ===== Radio Customize  ===== -->
<div class="card p-2 top_card">
    <div class="card-body">
        <!-- ===== Page Title, Add Button, Search Box  ===== -->
        <div class="row">
            <div class="col-md-6 content-title">
                <span class="title">
                    <a href="" class="title-btn red" id="">Manage Radio</a>
                </span>
                <div class="title-line category-title-line" id="categoryLine"></div>
            </div>
            <div class="col-md-6">
                <a href="radio/create" class="addBtn"><span class="iconify mr-2"
                        data-icon="bi:plus-circle-fill"></span>Add Radio</a>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-9 col-12">
                <div class="row mt-3">
                    <!-- Select Category -->
                    <div class="col-lg-3 col-4">
                        <select class="form-select" id="category">
                            <option value="all">All</option>
                            <option value="popular">Popular</option>
                            <option value="free">Free</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>
                    <!-- End Select Category -->

                    <!-- Select Country -->
                    <div class="col-lg-3 col-4">
                        <select class="form-select" name="country_id" id="country_id">
                            <option disabled selected>Country</option>
                            @if ($country)
                            @foreach ($country as $countr)
                            <option value="{{$countr->id}}">{{$countr->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- End Select Country -->

                    <!-- Select Language -->
                    <div class="col-lg-3 col-4">
                        <select class="form-select" name="language_id" id="language_id">
                            <option disabled selected>All Language</option>
                            @if ($languages)
                            @foreach ($languages as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-3 col-12">
                        <button class="input-group-text search btn-danger" id="filter-search">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--bx" width="1em" height="1em"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" data-icon="bx:bx-search">
                                <path
                                    d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6z"
                                    fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- End Select Language -->
                </div>
            </div>

            <div class="col-lg-3 col-12 mt-3">

                <div class="d-flex  align-items-center justify-content-between">
                    <div class="form-check me-2">
                        <input class="form-check-input checkAll" data-checkwhat="chkSelect" type="checkbox" value="">
                        <label class="form-check-label" for="action">
                            Select All
                        </label>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><button disabled class="dropdown-item" onclick="statusControl('enable')">Enable</button>
                            </li>
                            <li><button disabled class="dropdown-item"
                                    onclick="statusControl('disable')">Disable</button></li>
                            <li><button disabled class="dropdown-item" onclick="statusControl('delete')">Delete</button>
                            </li>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== End Page Title, Add Button, Search Box  ===== -->


    </div>
</div>
<!-- ===== End Radio Customize  ===== -->
<div class="main-content-body mb-5" id="mainContentBody">
    <style></style>
    {{-- single content --}}
    <div class="row" id="filterData">
        @if (!$target->isEmpty())
            @foreach ($target as $data)
            <div class="col-md-4 single-content margin-top-40">
                <a href="radio/schedule/{{$data->id}}">
                    <div class="single-content-wraper margin-top-20">
                        <div class="language">{{ $data->language->name??"" }}</div>
                        @if (!empty($data->image))
                        <img src="{{ $data->image }}" alt="{{ $data->name }}" title="{{ $data->name }}" />
                        @else
                        <img src="{{ asset('assets/img/dummy.jpg') }}" alt="" />
                        @endif
                        <input class="form-check-input select-input chkSelect" type="checkbox" name="chkSelect[]"
                            value="{{ $data->id}}">
                        <div class="total-videos margin-top-20">

                            <p class="cat-title">{{ Str::limit($data->radio_name, 20) }}</p>
                            <div class="switch">
                                <label class="">
                                    <input type="checkbox" id="approval" data-id="{{$data->id}}" type="checkbox"
                                        @if($data->status=="active") ? checked : @endif>>
                                    <div class="slider round"></div>
                                </label>
                            </div>
                    </div>

                    <div class="content-actions m-2">
                            <a href="{{ url('admin/radio/edit', $data->id) }}" class="button">
                                <span class="iconify" data-icon="ant-design:edit-filled"></span>
                                Edit
                            </a>
                            {{-- <button class="delete tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete"> --}}
                            <button data-id="{{$data->id}}" class="deleteBtn"  type="submit" title="Delete" id="news">
                                <span class="iconify" data-icon="ant-design:delete-filled"></span>
                                Delete
                            </button>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    @else
    <div class="col-md-6">
        <h5 class="alert alert-warning">Radio Not Create Yet..</h5>
    </div>
    @endif
            <nav class="page-navigation d-flex justify-content-center py-3 ">
                {{$target->links()}}
            </nav>
</div>
{{-- single content --}}
</div>

{{-- End::Content Body --}}

{{-- Start::Create pannel --}}
<div class="modal fade tabindex="  role="dialog" aria-hidden="true" id="createModal">
    <div class="modal-dialog modal-lg">
        <div id="showCreateModal"></div>
    </div>
</div>

{{-- End::Create pannel --}}

@stop
@push('custom-js')
<script type="text/javascript">

    var allVals = [];
    $(".checkAll").click(function () {
        $('.dropdown-menu li button').removeAttr('disabled');
        checkwhat = $(this).data("checkwhat");
        $('input:checkbox.' + checkwhat).not(this).prop('checked', this.checked);
        updateTextArea()
    });

    function updateTextArea() {
        allVals.length = 0;
        $(".chkSelect:checked").each(function () {
            allVals.push($(this).val());
        });
        console.log(allVals)
        $('.dropdown-menu li button').removeAttr('disabled');
    }


        $("input[name='chkSelect[]']").click(function(){

            updateTextArea();
        });

    $(document).on("click", ".deleteBtn", function () {
        let dataId = $(this).attr("data-id")
        let url = baseUrl + "/admin/radio/" + dataId
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



    $(document).on("click", "#filter-search", function (e) {

        e.preventDefault();
        var category = $('#category').val()
        var language_id = $('#language_id').val()
        var country_id = $('#country_id').val()
        $("#preloader").removeClass('d-none');
        $.ajax({
            url: baseUrl+"/admin/filter-radio",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                category: category,
                language_id: language_id,
                country_id: country_id,
            },
            success: function (res) {
                console.log(res)
                if (res.status === "success") {
                    var data = res.data
                    console.log(data);
                    $("#preloader").addClass('d-none');
                    $("#filterData").empty()
                    data.forEach(function (item) {
                        $("#filterData").append(`
                        <div class="col-md-4 single-content margin-top-40">
                            <div class="single-content-wraper margin-top-20">
                                <div class="language">${item.language.name}</div>
                                <img src="${item.image}" alt="" title="" />
                                <input class="form-check-input select-input chkSelect" type="checkbox" name="chkSelect[]" value="${item.id}" >
                                <div class="total-videos margin-top-20">
                                    <p class="cat-title">${item.radio_name.substring(0, 20).concat('...')}</p>
                                    <div class="switch">
                        <label class="">
                             <input id="approval" data-id="${item.id}" type="checkbox" ${item.status=="active" ? "checked" : ''}>
                            <div class="slider round"></div>
                        </label>
                    </div>


                                   {{--  <label class="switch">
                    <input id="approval" data-id="${item.id}" type="checkbox" ${item.status=="active" ? "checked" : ''}>
                                        <span class="slider round"></span>
                                    </label>
                                    <h4 class="number">{{$numberVideo[$data->id] ?? '0'}}</h4>
                                    <span>Total Videos This Category</span> --}}
                                </div>

                                <div class="content-actions m-2">
                                        <a href="admin/radio/edit/${item.id}" class="button">
                                            <span class="iconify" data-icon="ant-design:edit-filled"></span>
                                            Edit
                                        </a>
                                        {{-- <button class="delete tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete"> --}}
                                        <button type="submit" title="Delete" id="news" onclick="deleteItem('admin/radio/${item.id}')">
                                            <span class="iconify" data-icon="ant-design:delete-filled"></span>
                                            Delete
                                        </button>

                                </div>
                            </div>
                        </div>
                        `)
                    });


                } else {
                    $("#filterData").empty()
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    });

    function statusControl(status) {
        $.ajax({
            url: baseUrl+"/admin/status-radioApproval",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: allVals,
                status: status
            },
            success: function (res) {
                console.log(res.success)
                if (res) {
                    toastr.success('Successfully Update', );
                    location.reload(true);
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                if(jqXhr.status == 422 &&  jqXhr.responseJSON.status == "error"){
                    toastr.error( jqXhr.responseJSON.message)
                    $("#preloader").addClass('d-none');
                }
            }
        }); //ajax
    }

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
            url: baseUrl+"/admin/manage-radioApproval",
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
                console.log(res)
                if (res) {
                    toastr.success('Successfully Update', );
                    $("#preloader").addClass('d-none');
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                if(jqXhr.status == 422 &&  jqXhr.responseJSON.status == "error"){
                   toastr.error( jqXhr.responseJSON.message)
                    $("#preloader").addClass('d-none');
                }
            }
        }); //ajax
    });






    //privecy text editor


    ClassicEditor.create(document.querySelector("#description"))
        .then((editor) => {
            faqEditor = editor;
            console.log(faqEditor);
        })

</script>

@endpush
