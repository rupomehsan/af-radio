@extends('layouts.default.master')
@section('data_count')
{{-- Start:: content heading --}}
<div class="content-heading">
    <div class="row">
        {{-- title --}}
        <div class="col-md-8 content-title">
            <div class="row">
                <div class="col-md-6">
                    <span class="title">
                        <a href="" class="title-btn red" id="">Manage Radio</a>
                    </span>
                    <div class="title-line category-title-line" id="categoryLine"></div>
                </div>
            </div>
        </div>
        {{-- title --}}

        {{-- search --}}
        {{-- <div class="col-md-4 text-right">
            <form action="/category/filter" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group content-search">
                    <button class="input-group-text search" id="addon-wrapping">
                        <span class="iconify" data-icon="bx:bx-search"></span>
                    </button>
                    <input name="fil_search" type="text" class="form-control search" placeholder="Search"
                        aria-label="fil_search">
                </div>
            </form>
        </div> --}}
        {{-- search --}}
    </div>
</div>
{{-- End:: content heading --}}

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
        <div class="row my-3">
            <div class="col-lg-9 col-12">
               

                <div class="row mt-5">
                    <!-- Select Category -->
                    <div class="col-lg-3 col-12">
                        <select class="form-select" id="category">
                            <option selected disabled>Category</option>
                            <option value="popular">Popular</option>
                            <option value="free">Free</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>
                    <!-- End Select Category -->

                    <!-- Select Country -->
                    <div class="col-lg-3 col-12">
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
                    <div class="col-lg-3 col-12">
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
                    <button class="input-group-text search" id="filter-search">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--bx" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" data-icon="bx:bx-search"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6z" fill="currentColor"></path></svg>
                    </button>
                    </div>
                    <!-- End Select Language -->
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="text-end">
                  
                <button class="btn btn-primery"><a href="radio/create" class="title-btn red btn" id=""><span class="iconify mr-2" data-icon="bi:plus-circle-fill"></span>Add Radio</a></button>
                </div>

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
                            <li><button disabled class="dropdown-item" onclick="statusControl('enable')" >Enable</button></li>
                            <li><button disabled class="dropdown-item" onclick="statusControl('disable')" >Disable</button></li>
                            <li><button disabled class="dropdown-item" onclick="statusControl('delete')" >Delete</button></li>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== End Page Title, Add Button, Search Box  ===== -->


    </div>
</div>
<!-- ===== End Radio Customize  ===== -->
<div class="main-content-body" id="mainContentBody">
    {{-- single content --}}
    <div class="row" id="filterData">
        @if (!$target->isEmpty())
        @foreach ($target as $data)

        <div class="col-md-4 single-content margin-top-40">
            
            <div class="single-content-wraper margin-top-20">
                <div class="language">{{ $data->language->name }}</div>
                @if (!empty($data->image))
                <img src="{{ URL::to('/') }}/uploads/radio/{{ $data->image }}" alt="{{ $data->name }}"
                    title="{{ $data->name }}" />
                @else
                <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                @endif
                  <input class="form-check-input select-input chkSelect" type="checkbox" name="chkSelect[]" value="{{ $data->id}}" >
                <div class="total-videos margin-top-20">
                    <p class="cat-title">{{ $data->radio_name }}</p>
                    <label class="switch">
                        <input id="approval" data-id="{{$data->id}}" type="checkbox" @if($data->status=="active") ? checked : @endif>
                        <span class="slider round"></span>
                    </label>
                    {{-- <div class="onoffswitch">
                        <input type="checkbox" class="onoffswitch-checkbox" data-id="{{$data->id}}" id="approval" tabindex="0" @if($data->status=="active") ? checked : @endif>
                        <label class="onoffswitch-label" for="approval">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div> --}}
                    {{-- <h4 class="number">{{$numberVideo[$data->id] ?? '0'}}</h4>
                    <span>Total Videos This Category</span> --}}
                </div>

                <div class="content-actions margin-top-20">
                    <form action="{{ URL::to('radio/' . $data->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                            
                        </span>
                        <button>
                            <a href="{{ url('radio/edit', $data->id) }}">
                                <span class="iconify" data-icon="ant-design:edit-filled"></span>
                                Edit News
                            </a>
                        </button>


                        {{-- <button class="delete tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete"> --}}
                        <button type="submit" onclick="return confirm('Are you sure?')" title="Delete" id="news">
                            <span class="iconify" data-icon="ant-design:delete-filled"></span>
                            Delete News
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-md-6">
            <h5 class="alert alert-warning">Radio Not Create Yet..</h5>
        </div>
        @endif

    </div>
    {{-- single content --}}
</div>

{{-- End::Content Body --}}

{{-- Start::Create pannel --}}
<div class="modal fade tabindex=" -1" role="dialog" aria-hidden="true" id="createModal">
    <div class="modal-dialog modal-lg">
        <div id="showCreateModal"></div>
    </div>
</div>

{{-- End::Create pannel --}}

@stop
@push('custom-js')
<script type="text/javascript">
    var allVals = [];
    $(".checkAll").click(function(){
        $('.dropdown-menu li button').removeAttr('disabled');
        checkwhat  = $(this).data("checkwhat");
        $('input:checkbox.'+checkwhat).not(this).prop('checked', this.checked);
          updateTextArea()
    });
  
    function updateTextArea() {
      allVals.length= 0;
      $(".chkSelect:checked").each(function () {
        allVals.push($(this).val());
      });
      console.log(allVals)
      $('.dropdown-menu li button').removeAttr('disabled');
    }

   $(function () {
      $("input[name='chkSelect[]']").click(updateTextArea);
      updateTextArea();
    });
        


    $(document).on("click", "#enable", function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ URL::to('enable-radioApproval') }}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: allVals 
            },
            success: function (res) {
                console.log(res.success)
                if (res) {
                    toastr.success('Successfully Update', );
                    location.reload(true);
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    }); 
    
    $(document).on("click", "#filter-search", function (e) {
        e.preventDefault();
        var category = $('#category').val()
        var language_id = $('#language_id').val()
        var country_id  = $('#country_id').val()
        $.ajax({
            url: "{{ URL::to('filter-radio') }}",
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
                if(res.status === "success"){
                    var data = res.data
                    console.log(data);
                    $("#filterData").empty()
                    data.forEach(function(item){
                        $("#filterData").append(`
                        <div class="col-md-4 single-content margin-top-40">
                            <div class="single-content-wraper margin-top-20">
                                <div class="language">${item.language.name}</div>
                                <img src="http://127.0.0.1:8000/uploads/radio/${item.image}" alt="" title="" />
                                <input class="form-check-input select-input chkSelect" type="checkbox" name="chkSelect[]" value="${item.id}" >
                                <div class="total-videos margin-top-20">
                                    <p class="cat-title">${item.radio_name}</p>
                                    <label class="switch">
                    <input id="approval" data-id="${item.id}" type="checkbox" ${item.status=="active" ? "checked" : ''}>
                                        <span class="slider round"></span>
                                    </label>
                                    {{-- <h4 class="number">{{$numberVideo[$data->id] ?? '0'}}</h4>
                                    <span>Total Videos This Category</span> --}}
                                </div>

                                <div class="content-actions margin-top-20">
                                    <form action="http://127.0.0.1:8000/radio/${item.id}" method="POST">
                                        @csrf
                                        @method('DELETE')      
                                        </span>
                                        <button>
                                            <a href="http://127.0.0.1:8000/radio/edit/${item.id}">
                                                <span class="iconify" data-icon="ant-design:edit-filled"></span>
                                                Edit News
                                            </a>
                                        </button>
                                        {{-- <button class="delete tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete"> --}}
                                        <button type="submit" onclick="return confirm('Are you sure?')" title="Delete" id="news">
                                            <span class="iconify" data-icon="ant-design:delete-filled"></span>
                                            Delete News
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        `)
                    });

                    
                }else{
                    $("#filterData").empty()
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    });

    function statusControl(status){
           $.ajax({
            url: "{{ URL::to('status-radioApproval') }}",
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
                    toastr.success('Successfully Delete', );
                    location.reload(true);
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    }

     $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ URL::to('delete-radioApproval') }}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: allVals 
            },
            success: function (res) {
                console.log(res.success)
                if (res) {
                    toastr.success('Successfully Delete', );
                    location.reload(true);
                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    });

      $(document).on("click", "#disable", function (e) {
        e.preventDefault();
       
        $.ajax({
            url: "{{ URL::to('disable-radioApproval') }}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: allVals 
            },
            success: function (res) {
                console.log(res.success)
                if (res) {
                    toastr.success('Successfully Update', );
                    location.reload(true);

                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
        }); //ajax
    });

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
        $.ajax({
            url: "{{ URL::to('manage-radioApproval') }}",
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
                    toastr.success('Successfully Update', );

                }
            },
            error: function (jqXhr, ajaxOptions, thrownError) {}
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
