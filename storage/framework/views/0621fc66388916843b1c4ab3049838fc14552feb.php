<?php $__env->startSection('data_count'); ?>
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
                
                <div class="col-sm-7 col-md-6 col-lg-7 col-xl-6 ">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-sm-3 col-md-3 ">
                            <h6 class="font-weight-bold">Package</h6>
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
                
            </div>
        </div>
        

        

        <div class="row margin-top-40 content-details px-3">
            <table class="table border ">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="width: 10%" class="text-center"><input type="checkbox"> Sl</th>
                    <th scope="col" style="width: 10%" class="text-center">Package Name</th>
                    <th scope="col" style="width: 10%" class="text-center">Price</th>
                    <th scope="col" style="width: 10%" class="text-center">Validity</th>
                    <th scope="col" style="width: 10%" class="text-center">Status</th>
                    <th scope="col" style="width: 20%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody class="text-center" id="tableBody">


                </tbody>
            </table>
            <ul id="paginateNav" class="pagination justify-content-end"></ul>

        </div>
        
        
        <div class="modal fade" id="playlist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="padding: 0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Packages</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="submitForm" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="id">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Package Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Enter package name">
                                <span class="text-danger" id="name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Select package validity</label>
                                <select name="validity" id="validity"  class="form-control ">
                                    <option value="" selected="" disabled>Enter Validity</option>
                                    <option value="1">1 Day</option>
                                    <option value="7">1 Week (7 Day)</option>
                                    <option value="14">2 Week (14 Day)</option>
                                    <option value="30">1 Month (30 Day)</option>
                                    <option value="90">3 Month (90 Day)</option>
                                    <option value="180">6 Month (180 Day)</option>
                                    <option value="365">1 Year (365 Day)</option>
                                </select>
                                <span class="text-danger" id="validity_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Package Price</label>
                                <input type="text" class="form-control" name="price" id="price"
                                       placeholder="Enter package price">
                                <span class="text-danger" id="price_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Description</label>
                                <input type="text" class="form-control" name="description" id="description"
                                       placeholder="Enter Short Title">
                                <span class="text-danger" id="description_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Select Status </label>
                                <select name="status" class="form-control status" id="packageStatus">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger" id="status_error"></span>
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
        
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(function () {
            url = rootUrl + "package"
            getContestData(url)
        })

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


        function appendTableData(response, cb = () => {
        }) {

            $("#tableBody").empty()
            if (response.data.data.length > 0) {
                response.data.data.forEach((item, index) => {
                    $("#tableBody").append(`
                                   <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.name}</td>
                                        <td>${item.price}</td>
                                        <td>${item.validity}</td>

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
                    getContestData(rootUrl + "package" + "?page=" + selectPage)
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
        })

        $(".cancel-btn").click(function () {
            $("#playlist").modal('hide')
        })


        function getSearchData(data) {
            $.ajax({
                method: "get",
                url: rootUrl + "get_package_search_data",
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
                url = rootUrl + "package/" + id
            } else {
                url = rootUrl + "package"
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
            let url = rootUrl + "package/" + contestId
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
                            $("#audioFileSec").empty()
                            $("#multipleAudioSec").empty()
                            Object.entries(response.data).forEach((item) => {
                                $("#" + item[0]).val(item[1])
                                if(item[0]==="status"){
                                    $("." + item[0]).val(item[1])
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
            let contestId = $(this).attr("data-id")
            let url = rootUrl + "package/" + contestId
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

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/package/index.blade.php ENDPATH**/ ?>