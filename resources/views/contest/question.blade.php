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
                <div class="col-sm-7 col-md-6 col-lg-7 col-xl-6 ">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-sm-3 col-md-3">
                            <h6 class="font-weight-bold">Contest Questions</h6>
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
                        <button data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"
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
                    <th scope="col" style="width: 10%" class="text-center">Question</th>
                    <th scope="col" style="width: 10%" class="text-center">Right Answer</th>
                    <th scope="col" style="width: 10%" class="text-center">Participant</th>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Contest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="submitForm" method="post">
                        @csrf
                        <input type="hidden" id="id">
                        <div class="modal-body text-center">
                            <input type="hidden" name="contest_id" id="contest_id">
                            <div class="form-group">

                                <input type="text" class="form-control" name="question" id="question"
                                       placeholder="Question">
                                <span class="text-danger" id="question_error"></span>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" name="answer" id="1" value="1">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" name="option_one" id="option_one"
                                       placeholder="Answer">
                            </div>
                            <span class="text-danger" id="option_one_error"></span>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" name="answer" id="2" value="2">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" name="option_two" id="option_two"
                                       placeholder="Answer">
                            </div>
                            <span class="text-danger" id="option_two_error"></span>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" name="answer" id="3" value="3">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" name="option_three" id="option_three"
                                       placeholder="Answer">
                            </div>
                            <span class="text-danger" id="option_three_error"></span>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" name="answer" id="4" value="4">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" name="option_four" id="option_four"
                                       placeholder="Answer">
                            </div>
                            <span class="text-danger text-center" id="option_four_error"></span>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitButton" class="btn btn-secondary px-3 py-2">Send
                                Notification &
                                Start
                            </button>
                            <button type="button" class="btn btn-light border cancel-btn border-dark px-5 py-2"
                                    data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End:: modal section --}}


@stop
@push('custom-js')
    <script type="text/javascript">
        var ContestId = "{{request()->segment(4)}}"

        $(".cancel-btn").click(function () {
            $("#exampleModal").modal('hide')
        })
        $(".addItemBtn").click(function () {
            $("#submitForm")[0].reset()
            $("#submitButton").text("Send Notification & Start")
        })
        $(function () {
            var ContestId = "{{request()->segment(4)}}"
            $("#contest_id").val(ContestId)
            url = rootUrl + "contest_questions"
            getContestData(url)
            $.ajax({
                url: rootUrl + "get_premium_status",
                type: "get",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function (res) {
                    if (res.status === "success") {
                        res.data.forEach((item) => {
                            if (item.service_name === "contest" && item.status === "active") {
                                $("#approval").prop('checked', "true")
                            }
                        })
                    }
                },
                error: function (jqXhr, ajaxOptions, thrownError) {

                }
            });


        })

        function getContestData(url) {
            $.ajax({
                method: "get",
                url: url,
                dataType: "json",
                data:{"contestId":ContestId},
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
                                        <td>${item.question}</td>
                                        <td>${rightAnswer(item.answer)}</td>
                                        <td>${item.contest_list.length}</td>
                                        <td> <div class="${item.status === "Ongoing" ? "status-ongoing" : "status-finished"}">${item.status}</div></td>
                                        <td>
                                            <div class="table-btn d-flex align-items-center justify-content-center" style="margin-top: -10px;">
                                                        <a href="{{url('admin/contest/participant-list')}}/${item.id}" class="d-flex btn-sm align-items-center justify-content-center text-decoration-none btn tn-light border">
                                                   <iconify-icon icon="ant-design:read-outlined" style="color: #063288;margin: 0px 5px;"></iconify-icon>View </a>

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

                    function rightAnswer(answer) {
                        console.log(answer)
                        var ans = ''
                        if (answer == 1) {
                            ans = item.option_one
                        } else if (answer == 2) {
                            ans = item.option_two
                        } else if (answer == 3) {
                            ans = item.option_three
                        } else if (answer == 4) {
                            ans = item.option_four
                        }
                        return ans
                    }


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
                    getContestData(rootUrl + "contest" + "?page=" + selectPage)
                }
            });
        }


        // end
        // pagination
        // end

        function getSearchData(data) {

            $.ajax({
                method: "get",
                url: rootUrl + "get_contest_questions_search_data",
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
            if (method === "patch") {
                url = rootUrl + "contest_questions/" + $("#id").val()
            } else {
                url = rootUrl + "contest_questions"
            }
            let formData = $(this)
            formSubmit(method, url, formData, "submitButton");
        })

        $(document).on("click", ".editBtn", function () {
            let contestId = $(this).attr("data-id")
            let url = rootUrl + "contest_questions/" + contestId
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
                            $("#exampleModal").modal("show")
                            Object.entries(response.data).forEach((item) => {
                                // console.log(item)
                                $("#submitButton").text("Update")
                                $("#submitForm").attr("method", "patch")
                                $("#id").val(contestId)
                                if (item[0] !== "answer") {
                                    $(`input[name=${item[0]}`).val(item[1])
                                }
                                if (item[0] === "answer") {
                                    $("#" + item[1]).prop('checked', true)
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
            let url = rootUrl + "contest_questions/" + contestId
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
@endpush
