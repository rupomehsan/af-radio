@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
    <div class="modal-content mb-5">
        <div class="modal-title">
            <h4>Edit Radio</h4>
        </div>
        <form id="editNewsform" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $target->id }}">
            <div class="form-group margin-top-40">
                <label for="language_id">Language</label>
                <select name="language_id" id="language_id" class="form-control create-form">
                    <option selected disabled>Select Language</option>
                    @if (!empty($languages))
                        @foreach ($languages as $id => $name)
                            <option @if ($target->language_id == $id) ? selected : null
                                    @endif value="{{$id}}">{{$name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group margin-top-40">
                <label for="country_id">Country</label>
                <select name="country_id" id="country_id" class="form-control create-form">
                    <option selected disabled>Select Country</option>
                    @if (!empty($countries))
                        @foreach ($countries as $id => $name)
                            <option @if ($target->country_id == $id) ? selected : null
                                    @endif value="{{ $id }}">{{ $name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group margin-top-40">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control create-form">
                    <option selected disabled>Select Category</option>
                    <option @if ($target->category === 'free' ) ? selected : null @endif value="free">Free</option>
                    <option @if ($target->category === 'premium') ? selected : null @endif value="premium">Premium
                    </option>
                </select>
                {{-- <input name="name" type="text" class="form-control create-form" id="name" placeholder="Category Name"> --}}
            </div>

            <div class="form-group">
                <label for="title">Radio Name </label>
                <input class="form-control create-form" id="radio_name" name="radio_name" rows="0"
                       placeholder="Write Here Title" value="{{ $target->radio_name }}">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="title">Radio Frequency</label>
                <input class="form-control create-form" id="title" name="radio_frequency" rows="0"
                       placeholder="Write Here Title" value="{{ $target->radio_frequency }}">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="title">Radio Url</label>
                <input class="form-control create-form" id="title" name="radio_url" rows="0"
                       placeholder="Write Here Title"
                       value="{{ $target->radio_url }}">
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="description">News Description</label>
                <textarea class="form-control create-form" id="content" name="description" rows="10"
                          placeholder="Write Here Description" style="height:220px;">{{$target->description}}</textarea>
                <span class="text-danger"></span>
                {{-- <input type="text" name="description" id=""> --}}
            </div>
            <div class="col-md-6">
                <div class="image" id="image">
                    <div class="file-upload-edit">
                        <div class="image-upload-wrap-edit">
                            <input type="hidden" name="imageEdit" id="imageUrl">
                            <input value="" name="image" class="file-upload-input-edit file-uploader" type='file'
                                   onchange="readURLEdit(this);" accept="image/*"/>
                            <div class="drag-text-edit text-center">
                                <span class="iconify" data-icon="bx:bx-image-alt"></span> <br>
                                <span>Upload Image Or Drag Here</span>
                            </div>
                        </div>
                        <div class="file-upload-content-edit">
                            <img class="file-upload-image-edit" src="{{$target->image??asset('assets/img/dummy.jpg') }}" alt="{{ $target->name }}"/>
                            <div class="image-title-wrap-edit">
                                <button type="button" onclick="removeUploadEdit()" class="remove-image-edit">
                                    <span class="iconify" data-icon="akar-icons:cross"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($target->video_link)
                <div class="form-group" id="link">
                    <label for="image" class="mt-3">YouTube Video URL:</label><br>
                    <input type="text" name="video_link" class="form-control create-form" id="video_link"
                           value="{{$target->video_link}}">
                    <span class="text-danger"></span>
                </div>
            @endif


            {{-- <div class="form-group">
                <label for="image" class="mt-3">Gallery Image</label><br>
                <input type="file" name="gallery_image" id="gallery_image">
                <span class="text-danger"></span>
            </div> --}}


            <div class="actions margin-top-40">
                <button class="submit" type="submit" id="editNews">Update</button>
                <a href="/admin/radio">Cancel</a>
            </div>
        </form>

    </div>

@stop
@push('custom-js')
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });

    </script>
    <script>
        $(document).on("change", "#news_type", function (e) {
            alert($(this).val());
            if ($(this).val() == "video") {
                $("#image").after(`
              <div class="form-group" id="link">
            <label for="image" class="mt-3">YouTube Video URL:</label><br>
            <input type="text" name="news_link" class="form-control create-form" id="news_link">
            <span class="text-danger"></span>
        </div>
            `)
            } else if ($(this).val() == "image") {
                $("#link").empty();
            }

        })

        $(document).ready(function () {
            $('#categorySelect').select2();
            $('#categorySelect').select2({
                placeholder: 'Select Category'
            });
        });

        // category update
        $(document).on("click", "#editNews", function (e) {
            e.preventDefault();
            // alert("hi");
            var formData = new FormData($('#editNewsform')[0]);
            formData.append('description', $('.ck-content').text());
            // console.log($('.ck-content').text())
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $("#preloader").removeClass('d-none');
            $.ajax({
                url: baseUrl + "/admin/radio/update",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function (res) {
                    toastr.success('Radio  successfully updated', res, options);
                    setTimeout(location.reload.bind(location), 1000);
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 422) {
                        $("#preloader").addClass('d-none');
                        if (jqXhr.responseJSON.status == "error") {
                            toastr.error(jqXhr.responseJSON.message);
                        }
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 500) {
                        $("#preloader").addClass('d-none');
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        $("#preloader").addClass('d-none');
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    App.unblockUI();
                }
            });
        });
        //sub category create Modal
        $(document).on("change", ".file-uploader", function (e) {
            e.preventDefault();
            var file = e.target.files[0];
            let formData = new FormData()
            formData.append('file', file);
            formData.append('folder', 'radio');
            var showurl = window.origin + '/admin/radio/file-upload';
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
                    } else if (jqXhr.status == 404) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                }
            });
        });


    </script>
@endpush
