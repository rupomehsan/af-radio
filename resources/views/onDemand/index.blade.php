@extends('layouts.default.master')
@section('data_count')
    <div id="containerBox">
        <div id="loader">
            <div class="ph-item">
                <div class="ph-col-12">
                    <div class="ph-row">
                        <div class="ph-col-12 big"></div>
                        <br><br>
                    </div>
                    <div class="ph-picture"></div>
                </div>
            </div>
        </div>
        {{-- Start:: content heading --}}
        <div class="content-heading px-3">
            <div class="row justify-content-between align-items-center border">
                {{-- title --}}
                <div class="col-sm-7 col-md-6 col-lg-7 col-xl-6">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-sm-3 col-md-3 ">
                            <h6 class="font-weight-bold">OnDemand</h6>
                        </div>
                        <div class="col-sm-9 col-md-9 d-flex align-items-center">
                            <div class="switch">
                                <label class="mt-2">
                                    <input class="form-check-input" name="" type="checkbox"
                                           id="approval" value="playlist">
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <h6 class="m-3">Set As Premium</h6>
                        </div>
                    </div>

                </div>

                <div class="col-sm-5 col-md-6 col-lg-4 col-xl-2 d-flex align-items-center justify-content-md-end">
                    <div class="dropdown">
                        <button class="btn border border-dark dropdown-toggle d-flex align-items-center" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <iconify-icon icon="akar-icons:filter" style="color: black;margin-right: 5px;" width="20"
                                          height="20"></iconify-icon>
                            Filter
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="javascript:void(0)"
                               onclick="getSearchData('today')">Today</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_day')">Last
                                Day</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_week')">Last
                                Week</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_month')">Last
                                Month</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="getSearchData('last_year')">Last
                                Year</a>
                        </div>
                    </div>
                    <div class="addItemBtn ml-2">
                        <button data-toggle="modal" data-target="#playlist" data-whatever="@mdo"
                                class="btn btn-dark d-flex align-items-center justify-content-center">
                            <iconify-icon icon="carbon:add-filled" style="color: white;margin-right: 5px" width="20"
                                          height="20"></iconify-icon>
                            Add New
                        </button>
                    </div>
                </div>
                {{-- search --}}
            </div>
        </div>
        {{-- End:: content heading --}}

        {{-- Start::Content Body --}}

        <div class="row margin-top-40 content-details px-3">
            <table class="table border ">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="width: 10%" class="text-center"><input type="checkbox"> Sl</th>
                    <th scope="col" style="width: 10%" class="text-center">Create Date</th>
                    <th scope="col" style="width: 10%" class="text-center">Audio Type</th>

                    <th scope="col" style="width: 10%" class="text-center">Status</th>
                    <th scope="col" style="width: 20%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody class="text-center" id="tableBody">


                </tbody>
            </table>
            <ul id="paginateNav" class="pagination justify-content-end"></ul>

        </div>
        {{-- End::Content Body --}}
        {{-- modal section --}}
        <div class="modal fade" id="playlist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="padding: 0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Playlist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="submitForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Date</label>
                                <input type="date" class="form-control" name="date" id="date"
                                       placeholder="Question">
                                <span class="text-danger" id="date_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Audio Type</label>
                                <select name="audio_type" id="audio_type" class="form-control">
                                    <option value="" selected disabled>Select Audio Type</option>
                                    <option value="audio-link">Audio Link</option>
                                    <option value="audio-file">Audio File</option>
                                </select>
                                <span class="text-danger" id="audio_type_error"></span>
                            </div>
                            <div class="form-group" id="audioFileSec">

                            </div>

                            <label for="recipient-name" class="col-form-label">Image</label>
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

                            <div class="file-upload-edit d-none">
                                <div class="image-upload-wrap-edit">
                                    <input type="hidden" name="imageEdit" id="imageUrlEdt">
                                    <input value="" name="" class="file-upload-input-edit file-uploader" type='file'
                                           onchange="readURLEdit(this);" accept="image/*"/>
                                    <div class="drag-text-edit text-center">
                                        <span class="iconify" data-icon="bx:bx-image-alt"></span> <br>
                                        <span>Upload Image Or Drag Here</span>
                                    </div>
                                </div>
                                <div class="file-upload-content-edit">
                                    <img class="file-upload-image-edit" src="" alt=""/>
                                    <div class="image-title-wrap-edit">
                                        <button type="button" onclick="removeUploadEdit()" class="remove-image-edit">
                                            <span class="iconify" data-icon="akar-icons:cross"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitButton" class="btn btn-secondary px-5 py-2">
                                Create
                            </button>
                            <button type="button" class="btn btn-light border border-dark px-5 py-2 cancel-btn"
                                    data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End:: modal section --}}
    </div>
@stop
@push('custom-js')
    <script type="text/javascript">
        function getContestData(url, cb = () => {
        }) {
            // $('#preloader').removeClass('d-none')
            $.ajax({
                method: "get",
                url: url,
                dataType: "json",
                // beforeSend: function () {
                //     endLoading()
                //     startLoading('#containerBox')
                // },
                success: function (response) {
                    if (response.status === 'success') {
                        appendTableData(response, () => {
                            endLoading()
                        })

                        cb()
                    }
                },
                error: function (err) {
                    console.log(err)
                },
                // complete: function (xhr, status) {
                //     $('#preloader').addClass('d-none')
                // }

            });
        }

        $(function () {
            url = rootUrl + "on_demand"
            getContestData(url)
            $.ajax({
                url: rootUrl + "get_premium_status",
                type: "get",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // beforeSend: function () {
                //     $('#preloader').removeClass('d-none')
                // },
                success: function (res) {
                    if (res.status === "success") {
                        res.data.forEach((item) => {
                            if (item.service_name === "on-demand" && item.status === "active") {
                                $("#approval").prop('checked', "true")
                            }
                        })

                    }
                },
                error: function (jqXhr, ajaxOptions, thrownError) {

                },
                // complete: function (xhr, status) {
                //     $('#preloader').addClass('d-none')
                // }
            });
        })

        function appendTableData(response, cb = () => {
        }) {
            $("#tableBody").empty()
            if (response.data.data.length > 0) {
                response.data.data.forEach((item, index) => {
                    $("#tableBody").append(`
                                   <tr>
                                        <td>${index + 1}</td>
                                        <td>${new Date(item.date).toLocaleString('en-us', {
                        month: 'long',
                        year: 'numeric',
                        day: 'numeric'
                    })}</td>
                                        <td>${item.audio_type}</td>

                                        <td> <div class="${item.status === "active" ? "status-ongoing" : "status-finished"}">${item.status}</div></td>
                                        <td>
                                            <div class="table-btn d-flex align-items-center justify-content-center" style="margin-top: -10px;">

                                                <button
                                                    data-id="${item.id}"
                                                    class="d-flex btn-sm align-items-center justify-content-center m-sm-2 btn tn-light border editBtn">
                                                    <iconify-icon icon="clarity:note-edit-solid"
                                                                  style="color: #063288;margin: 0px 5px;"></iconify-icon>
                                                    Edit
                                                </button>
                                                <button data-id="${item.id}" class="d-flex btn-sm align-items-center justify-content-center  btn btn-light border deleteBtn">
                                                    <iconify-icon icon="ant-design:delete-filled"
                                                                  style="color: #063288;margin: 0px 5px;"></iconify-icon>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                          `)
                })

                setPagination(
                    response.data.total,
                    response.data.per_page,
                    response.data.current_page,
                    response.data.next_page_url,
                    response.data.prev_page_url
                );
                paginateItemClick();
            } else {
                $("#tableBody").append(`
                        <tr>
                            <td colspan="6" class="alert alert-warning font-weight-bold">No data found</td>
                        </tr>
                    `);
            }
            setTimeout(() => {
                cb()
            }, 500)
        }

        // start
        // pagination
        // start

        function setPagination(totalItem, perPageItem, currentPage, nextPage, prevPage) {
            let pages = Math.ceil(totalItem / perPageItem);
            let nextPageId = nextPage
            let prevPageId = prevPage
            if (prevPageId !== null) {
                prevPageId = prevPage.split("=")
                prevPageId = prevPageId[1]
            }
            if (nextPageId !== null) {
                nextPageId = nextPage.split("=")
                nextPageId = nextPageId[1]
            }
            $("#paginateNav").empty();
            $("#paginateNav").append(`
               <li class="page-item ${prevPageId === null ? "disabled" : ""}" data-id=${prevPageId}><a class="page-link "  href="javascript:void(0)">Previous</a></li>
            `);
            for (let i = 0; i < pages; i++) {
                $("#paginateNav").append(`
            <li data-id="${i + 1}" class="page-item ${
                    i + 1 === currentPage ? "active" : ""
                }"><a class="page-link" href="javascript:void(0)">${i + 1}</a></li>
             `);
            }
            $("#paginateNav").append(`
               <li class="page-item ${nextPageId === null ? "disabled" : ""}" data-id=${nextPageId}><a class="page-link next-page " href="javascript:void(0)" >Next</a></li>
            `);
        }

        function paginateItemClick() {
            let selectPage = 1;
            $(".page-item").click(function () {
                selectPage = $(this).attr("data-id");
                if (selectPage !== "null") {
                    getContestData(rootUrl + "on_demand" + "?page=" + selectPage)
                }
            });
        }


        // end
        // pagination
        // end

        $(".addItemBtn").click(function () {
            $("#submitForm")[0].reset()
            $("#audioFileSec").empty()
            $("#submitButton").text("Create")
            $(".file-upload").removeClass("d-none")
            $(".file-upload-edit").addClass("d-none")
            $("#id").val('')
            $(".text-danger").empty()
        })

        $(".cancel-btn").click(function () {
            $("#playlist").modal('hide')
        })

        $(document).on("change", "#approval", function (e) {
            e.preventDefault();
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            var value = $(this).val();
            // alert(id);
            if ($(this).prop('checked')) {
                var properties = 'active'
                // alert(properties)
            } else {
                var properties = 'inactive'
                //  alert(properties)
            }

            $('#preloader').removeClass('d-none')
            $.ajax({
                url: rootUrl + "set_premium_status",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    value: value,
                    status: properties,
                },
                success: function (res) {
                    console.log(res)
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


        $(document).on("change", "#audio_type", function () {
            if ($(this).val() === "audio-link") {
                $("#audioFileSec").empty()
                $("#audioFileSec").append(`
         <label for="recipient-name" class="col-form-label">Audio Link</label>
<div  id="multipleAudioSec">
       <div class="d-flex justify-content-between align-items-center">
                       <input type="text" class="form-control mx-1" name="audio[title][]" id="" placeholder="Audio Link Title">
                       <input type="text" class="form-control mx-1" name="audio[link][]" id="" placeholder="Audio Link ">
                        <iconify-icon icon="carbon:add-filled" style="color: black;cursor: pointer" width="20" height="20" id="addLink"></iconify-icon>
        </div>

</div>

        `)


                $(document).on("click", ".remove-div", function () {
                    $(this).closest('div').remove();
                })


            } else if ($(this).val() === "audio-file") {
                $("#audioFileSec").empty()
                $("#audioFileSec").append(`


                             <label for="recipient-name" class="col-form-label">Upload Audio File</label>
<div  id="multipleAudioSec">
       <div class="d-flex justify-content-between align-items-center">
                       <input type="text" class="form-control mx-1" name="audio_title[]" id="" placeholder="Audio Title">
                       <input type="file" class="form-control mx-1" name="audio_file[]" id="">
                        <iconify-icon icon="carbon:add-filled" style="color: black;cursor: pointer" width="20" height="20" id="addAudio"></iconify-icon>
        </div>

</div>

        `)

                $(document).on("click", ".remove-div", function () {
                    $(this).closest('div').remove();
                })

            }
        })


        function getSearchData(data) {
            $.ajax({
                method: "get",
                url: rootUrl + "get_on_demand_search_data",
                dataType: "json",
                data: {"value": data},
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

        $("#submitForm").submit(function (e) {
            e.preventDefault()
            let url = ''
            let method = $(this).attr("method")
            let id = $("#id").val()
            if (id) {
                url = rootUrl + "on_demand/" + id
            } else {
                url = rootUrl + "on_demand"
            }
            let formData = new FormData(this)
            formSubmit(method, url, formData, "submitButton");

            function formSubmit(method, url, formData, buttonId = null, headers = null) {
                $('#preloader').removeClass('d-none')
                $.ajax({
                    method: method,
                    url: url,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        $('#' + buttonId).prop('disabled', true);
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message)
                            setTimeout(reload, 1000)

                            function reload() {
                                location.reload()
                            }
                        } else if (response.status == "error") {
                            toastr.error(response.message)
                        }
                    },
                    error: function (xhr, resp, text) {
                        if (xhr && xhr.responseText) {
                            // $('#preloader').addClass('d-none')
                            let response = JSON.parse(xhr.responseText);
                            console.log("response", response)
                            if (response.status === 'validate_error') {
                                $('#preloader').addClass('d-none')
                                $(".fa-spin").removeClass('fa-spinner')
                                $.each(response.data, function (index, message) {
                                    if (message.field && message.field !== 'global') {
                                        $('#' + message.field + '_error').html(message.error);
                                    } else if (message.error) {
                                        // toastr.error(message.error);
                                        console.log("err 0")
                                    } else {
                                        // toastr.error('Something went wrong', 'Please try again after sometime.');
                                        console.log("err 1")
                                    }
                                });
                            } else if (response.status === 'error') {
                                toastr.error(response.message);
                                console.log("err 2")
                            }
                        }
                    },
                    complete: function (xhr, status) {
                        $('#' + buttonId).prop('disabled', false);
                        $('#preloader').addClass('d-none')
                    }
                });

            }

        })

        $(document).on("click", ".editBtn", function () {
            let contestId = $(this).attr("data-id")
            let url = rootUrl + "on_demand/" + contestId
            getContest(url)

            function getContest(url) {
                $.ajax({
                    method: "get",
                    url: url,
                    dataType: "json",
                    beforeSend: function () {
                        $('#preloader').removeClass('d-none')
                        $(".file-upload-edit").removeClass("d-none")
                        $(".file-upload").addClass("d-none")
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $("#playlist").modal("show")
                            $("#submitButton").text("Update")
                            $("#id").val(contestId)
                            $(".text-danger").empty()
                            $("#audioFileSec").empty()
                            $("#multipleAudioSec").empty()
                            Object.entries(response.data).forEach((item) => {
                                // console.log(item)
                                if (item[0] === "image") {
                                    if (item[1] === null) {
                                        $('.file-upload-image-edit').attr('src', "{{asset('assets/img/dummy.jpg')}}")
                                        $('.file-upload-image').attr('src', "{{asset('assets/img/dummy.jpg')}}")
                                        $(".file-upload-content-edit").removeClass("d-none")
                                    } else {
                                        $('.file-upload-image-edit').attr('src', item[1])
                                        $('.file-upload-image').attr('src', item[1])
                                        $(".file-upload-content-edit").removeClass("d-none")
                                    }
                                } else {
                                    // $(`input[name=${item[0]}`).val(item[1])
                                    $("#" + item[0]).val(item[1])
                                }


                                if (item[0] === "audio_file" && item[1].length > 0) {
                                    $("#audioFileSec").empty()
                                    $("#audioFileSec").append(`
                                         <label for="recipient-name" class="col-form-label d-flex gap-3">Upload Audio File <iconify-icon icon="carbon:add-filled" style="color: black;cursor: pointer" width="20" height="20" id="addAudio"></iconify-icon></label>
                                           <div  id="multipleAudioSec">

                                           </div>

                                      `)
                                    item[1].forEach((list, index) => {
                                        $("#multipleAudioSec").append(`
                                       <div class="d-flex justify-content-between align-items-center">
                                               <input type="text" class="form-control mx-1 my-1" name="audio_title[]" id="" placeholder="Audio Title" value="${list.title || ""}">
                                               <input  type="file" class="form-control mx-1 d-none"  name="audio_file[]" id="files"  value=""><label for="" class="form-control mx-1 my-1 overflow-hidden">${list.file}</label>
 <iconify-icon icon="akar-icons:circle-minus-fill" style="color: black; cursor: pointer" width="20" height="20" data-id="${index}" class="remove-div"></iconify-icon>

                                            </div>
                                       `)
                                    })
                                    $(document).on("click", ".remove-div", function () {
                                        var result = confirm("Want to delete?");
                                        if (result == true) {
                                            var id = $(this).attr("data-id")
                                            $(this).closest('div').remove();
                                            $.ajax({
                                                url: rootUrl + "audio-file-delete-podcast",
                                                type: "post",
                                                dataType: "json",
                                                headers: {
                                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                                },
                                                data: {"contestId": contestId, "id": id},
                                                success: function (res) {
                                                    if (res.status === "success") {

                                                    }
                                                },
                                                error: function (xhr, resp, text) {
                                                    console.log(xhr);
                                                    // on error, tell the failed
                                                },
                                            });
                                        }
                                    })
                                }
                                if (item[0] === "audio_link" && item[1].length > 0) {
                                    $("#audioFileSec").empty()
                                    $("#audioFileSec").append(`
                                         <label for="recipient-name" class="col-form-label d-flex gap-3">Upload Audio Link <iconify-icon icon="carbon:add-filled" style="color: black;cursor: pointer" width="20" height="20" id="addLink"></iconify-icon></label>
                                           <div  id="multipleAudioSec">

                                           </div>

                                      `)
                                    item[1].forEach((list, index) => {
                                        $("#audioFileSec").append(`
                                       <div class="d-flex justify-content-between align-items-center">
                                               <input type="text" class="form-control mx-1 my-1" name="audio[title][]" id="" placeholder="Audio Title" value="${list.title || ""}">
                                               <input type="text" class="form-control mx-1" name="audio[link][]" id="" value="${list.link}">
 <iconify-icon icon="akar-icons:circle-minus-fill" style="color: black; cursor: pointer" width="20" height="20" data-id="${index}" class="remove-div"></iconify-icon>                                            </div>
                                       `)
                                    })


                                    $(document).on("click", ".remove-div", function () {
                                        $(this).closest('div').remove();
                                    })

                                }
                            })
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    },
                    complete: function () {
                        $('#preloader').addClass('d-none')
                    },

                });
            }
        })


        $(document).on("click", "#addAudio", function () {
            $("#multipleAudioSec").append(`
<div class="d-flex justify-content-between align-items-center mt-1">
 <input type="text" class="form-control mx-1" name="audio_title[]" id="" placeholder="Audio Title">
       <input type="file" class="form-control mx-1" name="audio_file[]" id="">
                        <iconify-icon icon="akar-icons:circle-minus-fill" style="color: black; cursor: pointer" width="20" height="20" class="remove-div"></iconify-icon>
 </div>
    `)
        })

        $(document).on("click", "#addLink", function () {

            $("#audioFileSec").append(`
<div class="d-flex justify-content-between align-items-center mt-1">
     <input type="text" class="form-control mx-1" name="audio[title][]" id="" placeholder="Audio Link Title">
                       <input type="text" class="form-control mx-1" name="audio[link][]" id="" placeholder="Audio Link ">
                           <iconify-icon icon="akar-icons:circle-minus-fill" style="color: black; cursor: pointer" width="20" height="20" class="remove-div"></iconify-icon>
 </div>
    `)
        })


        $(document).on("click", ".deleteBtn", function () {
            let contestId = $(this).attr("data-id")
            let url = rootUrl + "on_demand/" + contestId
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
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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


        $(document).on("change", ".file-uploader", function (e) {
            e.preventDefault();
            var urlLinkId = '';
            if ($(this).attr("id") === "image") {
                urlLinkId = "#imageUrl"
            } else {
                urlLinkId = "#imageUrlEdt"
            }
            var file = e.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'playlist');
            var showurl = window.origin + '/admin/language/file-upload';
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
                    $(urlLinkId).val(res.data);
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

    </script>
@endpush
