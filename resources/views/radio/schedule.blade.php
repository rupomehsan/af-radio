@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
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
        <div class="content-heading px-3">
            <div class="row justify-content-between align-items-center border py-2">
                {{-- title --}}
                <div class="col-sm-7 col-md-6 col-lg-7 col-xl-6">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Program Schedule</h6>
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
                        <button data-toggle="modal" data-target="#Schedule" data-whatever="@mdo"
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
            <table class="table border table-responsive-md">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="width: 10%" class="text-center"><input type="checkbox"> Sl</th>
                    <th scope="col" style="width: 10%" class="text-center">Rss Name</th>
                    <th scope="col" style="width: 10%" class="text-center">Title</th>
                    <th scope="col" style="width: 10%" class="text-center">Description</th>
                    <th scope="col" style="width: 10%" class="text-center">Start Time</th>
                    <th scope="col" style="width: 10%" class="text-center">End Time</th>
                    <th scope="col" style="width: 10%" class="text-center">Status</th>
                    <th scope="col" style="width: 20%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody class="text-center" id="tableBody">

                </tbody>
            </table>
            <ul id="paginateNav" class="pagination justify-content-end"></ul>
        </div>
    </div>
    {{-- End::Content Body --}}
    {{-- End::Content Body --}}
    {{-- modal section --}}
    <div class="modal fade modal-dialog-scrollable" id="Schedule" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Program Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="scheduleForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="radio_id" name="radio_id" value="">
                    <input type="hidden" id="id" value="">
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="text" class="form-control" id="rss_name" name="rss_name"
                                   placeholder="Rss Name">
                            <span class="text-danger text-capitalize" id="rss_name_error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            <span class="text-danger text-capitalize" id="title_error"></span>
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="description" name="description"
                                      placeholder="Description"
                                      rows="10" cols="10"></textarea>
                            <span class="text-danger text-capitalize" id="description_error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="summary" name="summary" placeholder="Summary">
                            <span class="text-danger text-capitalize" id="summary_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Day :</label>
                            <div class="weekDays-selector">
                                <input type="checkbox" id="sunday" name="days[]" class="weekday" value="sunday"/>
                                <label for="sunday">Sunday</label>
                                <input type="checkbox" id="monday" name="days[]" class="weekday" value="monday"/>
                                <label for="monday">Monday</label>
                                <input type="checkbox" id="tuesday" name="days[]" class="weekday" value="tuesday"/>
                                <label for="tuesday">Tuesday</label>
                                <input type="checkbox" id="wednesday" name="days[]" class="weekday" value="wednesday"/>
                                <label for="wednesday">Wednesday</label>
                                <input type="checkbox" id="thursday" name="days[]" class="weekday" value="thursday"/>
                                <label for="thursday">Thursday</label>
                                <input type="checkbox" id="friday" name="days[]" class="weekday" value="friday"/>
                                <label for="friday">Friday</label>
                                <input type="checkbox" id="saturday" name="days[]" class="weekday" value="saturday"/>
                                <label for="saturday">Saturday</label>
                            </div>
                            <span class="text-danger text-capitalize" id="days_error"></span>
                        </div>

                        <div class="form-group" style="position:relative;">
                            <iconify-icon icon="ic:baseline-access-time" style="position: absolute;right: 5px; top: 14px;z-index: 1;"></iconify-icon>
                            <input class="form-control create-form border pl-3" name="start_time" id="start_time"
                                   placeholder="Start Time">
                            <span class="text-danger text-capitalize" id="start_time_error"></span>
                        </div>
                        <div class="form-group" style="position:relative;">
                            <iconify-icon icon="ic:baseline-access-time" style="position: absolute;right: 5px; top: 14px;z-index: 1;"></iconify-icon>
                            <input class="form-control create-form border pl-3" name="end_time" id="end_time"
                                   placeholder="End Time">

                            <span class="text-danger text-capitalize" id="end_time_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="thumbnail-image-section"></div>
                            <div id="yourBtn" onclick="getFile()">Thumbnail</div>
                            <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file"
                                                                                         value="upload" name="thumbnail"
                                                                                         onchange="sub(this)"/></div>
                            <label for="" class="text-black-50">Recommeded size 60*60px</label>
                        </div>
                        <div class="form-group">
                            <div class="main-image-section"></div>
                            <div id="mainyourBtn" onclick="maingetFile()">Main Image</div>

                            <div style='height: 0px;width: 0px; overflow:hidden;'><input id="mainupfile" type="file"
                                                                                         value="upload" name="main"
                                                                                         onchange="mainsub(this)"/>
                            </div>
                            <label for="" class="text-black-50">Recommeded size 60*60px</label>
                        </div>
                        {{--                        <input type="file" name="image" class="form-control">--}}


                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitButton" class="btn btn-secondary px-5 py-2">Save</button>
                        <button type="button" class="btn btn-light cancel-btn border border-dark px-5 py-2"
                                data-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- End:: modal section --}}

@stop
@push('custom-js')
    <script type="text/javascript">
        $('#start_time').timepicker({footer: true, modal: true});
        $('#end_time').timepicker({footer: true, modal: true});
        var radioId = "{{request()->segment(4)}}"
        $(".addItemBtn").click(function () {
            $("#scheduleForm")[0].reset()
            $(".thumbnail-image-section").empty()
            $(".main-image-section").empty()
            $("#description").empty()
            $("#scheduleForm").attr("method", "post")
            $("#submitButton").text("Create")
            $(".text-danger").empty()
        })

        $(".cancel-btn").click(function () {
            $("#Schedule").modal('hide')
        })

        $(function () {
            $("#radio_id").val(radioId)
            url = rootUrl + "get_schedule_by_radio_id/" + radioId
            getScheduleData(url)

        })

        function getScheduleData(url, cb = () => {
        }) {
            $.ajax({
                method: "get",
                url: url,
                dataType: "json",
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
            });
        }

        function appendTableData(response, cb = () => {
        }) {
            $("#tableBody").empty()
            if (response.data.data.length > 0) {
                response.data.data.forEach((item, index) => {
                    $("#tableBody").append(`
                                   <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.rss_name}</td>
                                        <td>${item.title}</td>
                                        <td>${item.description}</td>
                                        <td>${item.start_time}</td>
                                        <td>${item.end_time}</td>
                                        <td>${item.status}</td>
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
                    setPagination(
                        response.data.total,
                        response.data.per_page,
                        response.data.current_page,
                        response.data.next_page_url,
                        response.data.prev_page_url
                    );
                    paginateItemClick();
                })
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
                    getScheduleData(rootUrl + "get_schedule_by_radio_id/" + radioId + "?page=" + selectPage)
                }
            });
        }
        // end
        // pagination
        // end
        $(document).on("click", ".editBtn", function () {
            let dataId = $(this).attr("data-id")
            let url = rootUrl + "schedule/" + dataId
            getContest(url)

            function getContest(url) {
                $.ajax({
                    method: "get",
                    url: url,
                    dataType: "json",
                    beforeSend: function () {
                        $('#preloader').removeClass('d-none')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $("#Schedule").modal("show")
                            $(".thumbnail-image-section").empty()
                            $(".main-image-section").empty()
                            $("#description").empty()
                            $(".text-danger").empty()
                            // var optionvalue = $("#time_zone")[0]
                            // var option = Object.values(optionvalue)
                            // var timeZoneArray = []
                            // option.forEach((item3, index, array) => {
                            //     var opt = item3.innerHTML
                            //     var gmt = opt.slice(0, -12);
                            //     timeZoneArray.push(gmt)
                            // })
                            Object.entries(response.data).forEach((item) => {

                                $("#submitButton").text("Update")
                                $("#id").val(dataId)
                                $("#" + item[0]).val(item[1])
                                // $(`input[name=${item[0]}`).val(item[1])
                                if (item[0] === "description" && item[1] !== null) {
                                    $("#description").html(item[1])
                                }
                                // if (item[0] === "time_zone" && item[1] !== null) {
                                //     if (timeZoneArray.includes(item[1])) {
                                //         $("#" + item[0]).val(item[1])
                                //     }
                                // }
                                if (item[0] === "days" && item[1] !== null) {
                                    item[1].forEach(function (day) {
                                        $("#" + day).prop("checked", "true")
                                    })
                                }

                                if (item[0] === "thumbnail" && item[1] !== null) {
                                    $(".thumbnail-image-section").append(`
                                    <img src="${item[1]}" class="img-fluid p-1 border" height="40" width="50" >
                                    `)
                                }
                                if (item[0] === "main_image" && item[1] !== null) {
                                    $(".main-image-section").append(`
                                    <img src="${item[1]}" class="img-fluid p-1 border" height="40" width="50" >
                                    `)
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


        $(document).on("click", ".deleteBtn", function () {
            let dataId = $(this).attr("data-id")
            let url = rootUrl + "schedule/" + dataId
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


        $("#scheduleForm").submit(function (e) {
            e.preventDefault()
            let url = ''
            let method = $(this).attr("method")
            let id = $("#id").val()
            if (id) {
                url = rootUrl + "schedule/" + id
            } else {
                url = rootUrl + "schedule"
            }
            let formData = new FormData(this)
            formSubmit(method, url, formData, "submitButton");

            function formSubmit(method, url, formData, buttonId = null, headers = null) {

                $.ajax({
                    method: method,
                    url: url,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        $('#preloader').removeClass('d-none')
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

        function getSearchData(data) {

            $.ajax({
                method: "get",
                url: rootUrl + "get_radio_schedule_search_data",
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


        function getFile() {
            document.getElementById("upfile").click();
        }

        function sub(obj) {
            var file = obj.value;
            var fileName = file.split("\\");
            document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
        }

        function maingetFile() {
            document.getElementById("mainupfile").click();
        }

        function mainsub(obj) {
            var file = obj.value;
            var fileName = file.split("\\");
            document.getElementById("mainyourBtn").innerHTML = fileName[fileName.length - 1];
        }
    </script>
@endpush
