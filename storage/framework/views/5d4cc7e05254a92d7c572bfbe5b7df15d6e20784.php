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
                
                <div class="col-md-6">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Contest Participant List</h6>
                        </div>

                    </div>

                </div>

                <div class="col-md-1 ">
                    <div class="dropdown">
                        <button class="btn border border-dark dropdown-toggle d-flex align-items-center" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <iconify-icon icon="akar-icons:filter" style="color: black;margin-right: 5px;" width="20"
                                          height="20"></iconify-icon>
                            Filter
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Today</a>
                            <a class="dropdown-item" href="#">Last Week</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
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
                    <th scope="col" style="width: 10%" class="text-center">User Name</th>
                    <th scope="col" style="width: 10%" class="text-center">Time</th>
                    <th scope="col" style="width: 10%" class="text-center">Answer</th>
                    <th scope="col" style="width: 10%" class="text-center">Status</th>
                </tr>
                </thead>
                <tbody class="text-center" id="tableBody">


                </tbody>
            </table>
            <ul id="paginateNav" class="pagination justify-content-end"></ul>
        </div>
        
        
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Contest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Question:</label>
                                <input type="text" class="form-control" id="recipient-name" placeholder="Question">
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" id="recipient-name" placeholder="Answer">
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" id="recipient-name" placeholder="Answer">
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" id="recipient-name" placeholder="Answer">
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-center">
                                <label class="custom-radio">
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <input type="text" class="form-control" id="recipient-name" placeholder="Answer">
                            </div>
                            <div class="footer-btn d-flex ">
                                <input placeholder="Start Date" type="text" onMouseOver="(this.type='date')"
                                       onMouseOut="(this.type='text')" id="date" class="form-control px-1">
                                <input placeholder="End Date" type="text" onMouseOver="(this.type='date')"
                                       onMouseOut="(this.type='text')" id="date" class="form-control">

                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-3 py-2">Send Notification & Start</button>
                        <button type="button" class="btn btn-light border border-dark px-5 py-2" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        var contestId = "<?php echo e(request()->segment(4)); ?>";
        url = rootUrl + "get_contest_participant/" + contestId
        $(function () {
            getTableData(url)

        })
        function getTableData(url) {
            $.ajax({
                method: "get",
                url: url,
                dataType: "json",
                success: function (response, cb = () => {
                }) {
                    if (response.status === 'success') {
                        $("#tableBody").empty()
                        if (response.data.data.length > 0) {
                            response.data.data.forEach((item, index) => {
                                $("#tableBody").append(`
                                   <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.user_name}</td>
                                        <td>${item.on_date}</td>
                                        <td>${rightAnswer(item.answer)}</td>
                                        <td> <div class="${item.answer === response.contest.answer ? "status-ongoing" : "status-finished"}"> ${item.answer === response.contest.answer ? "Right" : "Worng"} </div> </td>
                                    </tr>

                          `)

                                function rightAnswer(answer) {
                                    console.log(answer)
                                    var ans = ''
                                    if (answer == 1) {
                                        ans = response.contest.option_one
                                    } else if (answer == 2) {
                                        ans = response.contest.option_two
                                    } else if (answer == 3) {
                                        ans = response.contest.option_three
                                    } else if (answer == 4) {
                                        ans = response.contest.option_four
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
                            endLoading()
                        }, 500)

                    }

                },
                error: function (err) {
                    console.log(err)
                },

            });
        }
        // start
        // pagination
        // start

        function setPagination(totalItem, perPageItem, currentPage,nextPage,prevPage) {
            let pages = Math.ceil(totalItem / perPageItem);
            let nextPageId = nextPage
            let prevPageId = prevPage
            if(prevPageId!==null){
                prevPageId = prevPage.split("=")
                prevPageId= prevPageId[1]
            }
            if(nextPageId!==null){
                nextPageId = nextPage.split("=")
                nextPageId= nextPageId[1]
            }
            $("#paginateNav").empty();
            $("#paginateNav").append(`
               <li class="page-item ${prevPageId===null?"disabled":""}" data-id=${prevPageId}><a class="page-link "  href="javascript:void(0)">Previous</a></li>
            `);
            for (let i = 0; i < pages; i++) {
                $("#paginateNav").append(`
            <li data-id="${i + 1}" class="page-item ${
                    i + 1 === currentPage ? "active" : ""
                }"><a class="page-link" href="javascript:void(0)">${i + 1}</a></li>
             `);
            }
            $("#paginateNav").append(`
               <li class="page-item ${nextPageId===null?"disabled":""}" data-id=${nextPageId}><a class="page-link next-page " href="javascript:void(0)" >Next</a></li>
            `);
        }

        function paginateItemClick() {
            let selectPage = 1;
            $(".page-item").click(function () {
                selectPage = $(this).attr("data-id");
                if(selectPage!=="null"){
                    getTableData(url + "?page=" + selectPage)
                }
            });
        }


        // end
        // pagination
        // end
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/contest/participant_list.blade.php ENDPATH**/ ?>