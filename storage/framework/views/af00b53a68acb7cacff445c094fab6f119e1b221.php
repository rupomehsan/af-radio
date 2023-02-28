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
            <div class="row justify-content-between align-items-center border">
                
                <div class="col-sm-7 col-md-6 col-lg-7 col-xl-6">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-sm-3 col-md-3">
                            <h6 class="font-weight-bold">Live Request</h6>
                        </div>
                        <div class="col-sm-9 col-md-9 d-flex align-items-center">
                            <div class="switch">
                                <label class="mt-2">
                                    <input class="form-check-input" name="" type="checkbox"
                                           id="approval" value="live-request">
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
                </div>
                
            </div>
        </div>
        

        

        <div class="row margin-top-40 content-details px-3">
            <table class="table border ">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="width: 10%" class="text-center"><input type="checkbox"> Sl</th>
                    <th scope="col" style="width: 20%" class="text-center">Live Request</th>
                    <th scope="col" style="width: 30%" class="text-center">Text</th>
                    <th scope="col" style="width: 10%" class="text-center">Time</th>
                    <th scope="col" style="width: 30%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody class="text-center" id="tableBody">

                </tbody>
            </table>
            <ul id="paginateNav" class="pagination justify-content-end"></ul>
        </div>
    </div>
    


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(function () {
            url = rootUrl + "live-request"
            getScheduleData(url)

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
                            if (item.service_name === "live-request" && item.status === "active") {
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

        function getScheduleData(url) {
            $.ajax({
                method: "get",
                url: url,
                dataType: "json",
                // beforeSend: function () {
                //     $('#preloader').removeClass('d-none')
                // },
                success: function (response) {
                    if (response.status === 'success') {
                        appendTableData(response, () => {
                            endLoading()
                        })
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
            if (response.data.data.length > 0) {
                $("#tableBody").empty()
                response.data.data.forEach((item, index) => {
                    $("#tableBody").append(`
                                   <tr>
                                        <td>${index + 1}</td>
                                         <td>
                                            <iconify-icon icon="game-icons:lightning-frequency" style="color: black;transform: rotate(132deg);" width="30" height="30"></iconify-icon>
                                            <br>
                                            <audio  class="${item.audio||"d-none"}" controls >
                                              <source src="${baseUrl + item.audio}" type="audio/mpeg">
                                            </audio>

                                        </td>
                                        <td>${item.text||"N/A"}</td>
                                        <td>${item.on_date}</td>

                                        <td>
                                            <div class="table-btn d-flex align-items-center justify-content-center" style="margin-top: -10px;">
                                               <a href="${baseUrl + item.audio}" ${item.audio?"download":""}   class=" ${item.audio?"":"disabled"} d-flex btn-sm align-items-center justify-content-center m-sm-2 btn tn-light border"> <iconify-icon icon="mdi:download-circle" style="color: #063288;margin: 0px 5px;"></iconify-icon>
                                                   Download
                                                </a>
                                                <button
                                                    data-id="${item.id}"
                                                    class="${(item.status === "yes") ? "disabled btn-primary" : ""}  d-flex btn-sm align-items-center justify-content-center m-sm-2 btn tn-light border responseBtn">
                                                    <iconify-icon icon="clarity:note-edit-solid"
                                                                  style="color: #063288;margin: 0px 5px;"></iconify-icon>
                                                   ${(item.status === "yes") ? "Responsed" : "Response"}
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
                    getScheduleData(rootUrl + "live-request" + "?page=" + selectPage)
                }
            });
        }


        // end
        // pagination
        // end

        $(document).on("click", ".responseBtn", function () {
            let dataId = $(this).attr("data-id")
            let url = rootUrl + "live-request/" + dataId
            $.ajax({
                method: "patch",
                url: url,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function () {
                    $("#preloader").removeClass('d-none');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message)
                        setTimeout(reload, 1000)

                        function reload() {
                            location.reload()
                        }
                    }
                },
                error: function (err) {
                    console.log(err)
                },
            });
        })
        $(document).on("click", ".deleteBtn", function () {
            let dataId = $(this).attr("data-id")
            let url = rootUrl + "live-request/" + dataId
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

        function getSearchData(data) {

            $.ajax({
                method: "get",
                url: rootUrl + "get_live_request_search_data",
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


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ccninfot/afradio.ccninfotech.com/resources/views/liveRequest/index.blade.php ENDPATH**/ ?>