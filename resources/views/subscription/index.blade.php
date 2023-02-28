@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
    <div class="content-heading">
        <div class="row">
            {{-- title --}}
            <div class="col-md-8 content-title">
                <div class="row">

                    <div class="col-md-2">
                        <span class="title">Subscription</span>
                        <div class="title-line"></div>
                    </div>
                    <div class="col-md-2">
                        <span class="sub-title">
                            <a href="/admin/subscription/all-package" class="title-btn">Package</a>
                        </span>
                        <div class="title-line sub-category-title-line display-none"></div>
                    </div>

                </div>
            </div>
            {{-- title --}}

            {{-- search --}}
            {{-- <div class="col-md-4 text-right">
                <form method="POST" enctype="multipart/form-data">
                    <div class="input-group content-search">
                        <button type="button" class="input-group-text search search-btn" id="addon-wrapping">
                            <span class="iconify" data-icon="bx:bx-search"></span>
                        </button>
                        <input name="fil_search" type="text" class="form-control search" placeholder="Search"
                            aria-label="fil_search" id="searchText">
                    </div>
                </form>
            </div> --}}
            {{-- search --}}
        </div>
    </div>
    {{-- End:: content heading --}}

    {{-- Start::Content Body --}}
    <div class="row margin-top-40 content-details">

        <table class="table">
            <thead class="thead-light">
                <tr class="table-head">
                    <th scope="col" class="text-center">Serial</th>
                    <th scope="col" class="text-center">Subscriber Email</th>
                    <th scope="col" class="text-center">Pakage Name</th>
                    <th scope="col" class="text-center">Subscription Date</th>
                    {{-- <th scope="col" class="text-center">Subscription Period</th> --}}
                </tr>
            </thead>
            <tbody id="tableContent">
            </tbody>
        </table>
    </div>
    {{-- End::Content Body --}}


@stop
@push('custom-js')
    <script type="text/javascript">
        $(function() {
            // index data
            $(document).ready(function() {
                var sl = 1;
                var showurl = window.origin + '/api/v1/subscription/get-all';
                $.ajax({
                    url: showurl,
                    type: "get",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': localStorage.getItem('token'),
                    },
                    success: function(res) {
                        console.log(res)
                        if(res.status === 'success'){
                            res.data.forEach(function(item, i) {
                                $("#tableContent").append(`
                                    <tr>
                                        <th class="text-center" scope="row">${i + 1}</th>
                                        <td class="text-center">${item?.user?.email ? item?.user?.email : ''}</td>
                                        <td class="text-center">${item.packageName ? item.packageName : ''}</td>
                                        <td class="text-center">${item.added_on ? item.added_on : ''}</td>
                                    </tr>
                                `);
                            });
                        }

                    },
                    error: function(jqXhr, ajaxOptions, thrownError) {}
                }); //ajax
            });

        });
    </script>
@endpush
