@extends('frontend.layouts.client.index')
@section('content')
    <!-- Selected video section start -->
    <section class="video ">
        <div class="single-vidio-wrapper">
            <div class="video-area">
                {{-- <video width="100%" height="100%" controls>
                        <source
                            src="{{ URL::to('/') }}/uploads/video/1636205353.Sort video LOVE FROM FREE FIRE like and subscribe (1).mp4"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video> --}}

                {!! $embeded !!}
            </div>
        </div>

        <div class="single-vidio-description ptb-30">
            <div class="row single-vidio-rs">
                <div class="col-md-6 left-part-rs col-sm-12">
                    <div class="left-part">

                    </div>
                </div>
                <div class="col-md-6 right-part">
                    <ul>
                        <li>
                            <button type="button" class="share-button" data-toggle="modal" data-target="#shareModal">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Selected video section end -->

    {{-- Start:: You May Also Like video --}}
    <div class="container my-4 also-like">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-section-title">
                    <div class="title">
                        TV Channel
                    </div>
                    <div class="triangle"></div>
                    <div class="line"></div>
                </div>
            </div>
        </div>
        <!--Slides-->
        <?php
        $count = '1';
        ?>
        <div class="owl-carousel also-like-carousel owl-theme">
            @if (!$remainingTvInfo->isEmpty())
                @foreach ($remainingTvInfo as $data)
                    <div class="card item margin-top-40">

                        @if (!empty($data->image))
                            <img src="{{ URL::to('/') }}/uploads/tv/{{ $data->image }}"
                                alt="{{ $data->name }}" title="{{ $data->name }}" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                        @endif

                        <div class="card-body">
                            <h4 class="card-title">{{ $data->name }}</h4>
                            <a class="btn btn-primary mt-20" href="/frontend/live-tv/{{ $data->id }}">
                                <i class="fa fa-play" aria-hidden="true"></i>
                                Play Live
                            </a>
                        </div>
                    </div>
                    <?php
                    $count++;
                    ?>
                @endforeach
            @endif
        </div>
        <!--/.Slides-->
    </div>
    {{-- End:: You May Also Like video --}}


    {{-- share modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="shareModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content single-vido-modal">
                <div class="modal-header">
                    <span class="modal-title">Share</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="link-box">
                        <div class="input-group mb-3">
                            <input type="text" id="videoUrl" class="form-control" readonly value="{{ url()->full() }}">
                            <div class="input-group-append">
                                <button value="copy input-group-text" id="basic-addon2"
                                    onclick="copyToClipboard()">Copy!</button>
                                {{-- <span class="input-group-text" id="basic-addon2">Copy</span> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- report modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reportModal">
        <div class="modal-dialog modal-lg">
            <div id="showReportModal">
            </div>
        </div>
    </div>

@endsection

@push('custom-js')
    <script>
        $('.also-like-carousel').owlCarousel({
            items: 4,
            loop: true,
            autoplay: true,
            responsiveClass: true,
            margin: 20,
            nav: true,
            // dots: false,
            navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });

        //copy url
        function copyToClipboard() {
            document.getElementById("videoUrl").select();
            document.execCommand('copy');
        }

        // report Modal
        $(document).on("click", "#reportButton", function(e) {
            e.preventDefault();
            var id = $(this).data("id")
            $.ajax({
                url: "{{ URL::to('report/create') }}",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    video_id: id,
                },
                success: function(res) {
                    $("#showReportModal").html(res.html);
                },
                error: function(jqXhr, ajaxOptions, thrownError) {}
            }); //ajax
        });

        // report save
        $(document).on("click", "#createReport", function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportCreateForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: "{{ URL::to('report/store') }}",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(res) {
                    toastr.success('Report Send successfully', res, options);
                    setTimeout(location.reload.bind(location), 1000);
                },
                error: function(jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 422) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 500) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    App.unblockUI();
                }
            });
        });
    </script>
@endpush
