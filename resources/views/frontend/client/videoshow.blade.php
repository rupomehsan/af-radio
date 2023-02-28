@extends('frontend.layouts.client.index')
@section('content')
    <!-- Selected video section start -->
    <section class="video ">
        <div class="single-vidio-wrapper">
            <div class="video-area">
                @if (!empty($selectedVideoInfo->video))
                    <video width="100%" height="100%" controls>
                        <source
                            src="{{ URL::to('/') }}/uploads/video/1636205353.Sort video LOVE FROM FREE FIRE like and subscribe (1).mp4"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    {!! $embeded !!}
                @endif
            </div>
        </div>

        <div class="single-vidio-description ptb-30">
            <div class="row single-vidio-rs">
                <div class="col-md-6 left-part-rs col-sm-12">
                    <div class="left-part">
                        @if (!empty($selectedVideoInfo->thumbnail))
                            <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $selectedVideoInfo->thumbnail }}"
                                alt="{{ $selectedVideoInfo->title }}" title="{{ $selectedVideoInfo->title }}" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                        @endif
                        <div class="title">
                            <h3>{{ $selectedVideoInfo->title ?? '' }}</h3>
                            <p> <span class="borR">{{ $selectedVideoInfo->category_name ?? '' }} </span>
                                <span class="pl-2">{{ $selectedVideoInfo->duration ?? '' }} Min</span>
                            </p>
                            <p class="imdb">
                                <span> <i class="icofont icofont-star"></i>  {!! !empty($tmdbRating['vote_average']) ? $tmdbRating['vote_average'].' TMDB' : '' !!}  </span>
                                {{-- <span> <i class="fas fa-apple-alt"></i> 85%</span> --}}
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 right-part">
                    <ul>
                        <li>
                            <button type="button" class="share-button" data-toggle="modal" data-target="#commentData">
                                <i class="far fa-comments"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="share-button" data-toggle="modal" data-target="#shareModal">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </li>
                        <li>
                            {{-- <i class="fa fa-heart" style="color: white" aria-hidden="true"></i> --}}

                            {{-- favorite btn --}}
                            @if (!empty(Auth()->id()))
                                <?php
                                $checked = '';
                                if (in_array($selectedVideoInfo->id, $favoriteList)) {
                                    $checked = 'checked';
                                }
                                ?>
                                <input type="checkbox" class="video-id single-favorite" name="video_id"
                                    value="{{ $selectedVideoInfo->id }}" {{ $checked }}>

                            @endif
                            {{-- end favorite btn --}}
                        </li>
                        <li>
                            @if (!empty(Auth()->id()))
                                <button type="button" id="reportButton" class="share-button" data-toggle="modal"
                                    data-target="#reportModal" data-id="{{ $selectedVideoInfo->id }}">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="decription">
                    <p>{{ $selectedVideoInfo->description ?? '' }}</p>
                </div>
                <div class="dir-cast">
                    <p><b>Celibrities :</b> &nbsp;{{ $celibrityNames }}</p>
                </div>
                {{-- Start::Comment Section --}}
                @if ($selectedVideoInfo->comment_on_off === 'on')
                    <div class="comment-section col-md-12">
                        {{-- Start:: User Create Comment Section --}}
                        @if (!empty(Auth()->id()))
                            <form id="commentCreateForm" method="POST" enctype="multipart/form-data">
                                <div class="create-comment row">
                                    <div class="col-md-1 comment-user-img">
                                        @if (!empty(Auth::user()->image))
                                            <img src="{{ URL::to('/') }}/uploads/user/{{ Auth::user()->image }}"
                                                alt="{{ Auth::user()->name }}" />
                                        @else
                                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" />
                                        @endif
                                    </div>
                                    <div class="col-md-11 comment-submit">
                                        <input type="hidden" name="video_id" value="{{ $selectedVideoInfo->id }}">

                                        <input type="text" name="comment" class=""
                                            placeholder="Add a public comment..">

                                        <div class="comment-send text-right margin-top-10">
                                            <button type="submit" id="createComment">Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                        {{-- End:: User Create Comment Section --}}

                        {{-- Start:: Show Comment --}}
                        <div class="show-comment">
                            <div class="card">
                                <div class="card-header" id="headingComments">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse"
                                            id="allCommentsBtn" data-target="#allComments" aria-expanded="true"
                                            aria-controls="allComments">
                                            {!! !$commentInfo->isEmpty() ? sizeOf($commentInfo) : 0 !!} &nbsp; Comments
                                        </button>
                                    </h5>
                                </div>
                                <div id="allComments" class="collapse" aria-labelledby="headingComments"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="all-comments">
                                            @if (!$commentInfo->isEmpty())
                                                @foreach ($commentInfo as $comment)
                                                    <div class="row margin-top-20">
                                                        <div class="col-md-1 comment-user-img">
                                                            @if (!empty($comment->user_image))
                                                                <img src="{{ URL::to('/') }}/uploads/user/{{ $comment->user_image }}"
                                                                    alt="{{ $comment->user_name }}" />
                                                            @else
                                                                <img src="{{ URL::to('/') }}/uploads/no.jpeg" />
                                                            @endif
                                                        </div>
                                                        <div class="col-md-11">
                                                            <div class="comment-user-name">
                                                                {{ $comment->user_name }}&nbsp; <span
                                                                    class="white font-12">.&nbsp;{{ $comment->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="comment-user">
                                                                {{ $comment->comment }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End:: Show Comment --}}
                    </div>
                @endif
                {{-- End::Comment Section --}}
            </div>
        </div>
    </section>
    <!-- Selected video section end -->

    {{-- start:: series content --}}
    @if ($selectedVideoInfo->is_series === 'on')
        <div class="series-season row">
            <div class="col-md-2 offset-md-5">
                <div class="form-group margin-top-40">
                    <select name="season_id" id="seasonType" class="form-control create-form">
                        <option value="0">Select Season</option>
                        @foreach ($seasonList as $id => $name)
                            <?php
                            $selected = '';
                            if ($id == $selectedVideoInfo->season_id) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="{{ $id }}" {{ $selected }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- episode --}}
            @if (!$episodeInfo->isEmpty())
                <div class="container my-4 also-like" id="episodeData">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content-section-title">
                                <div class="title">
                                    Episodes
                                </div>
                                <div class="triangle"></div>
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                    <!--Slides-->
                    <?php
                    $count = '1';
                    // $class = 'horizontal-image';
                    // if (!empty($settingsData[$name])) {
                    //     if ($settingsData[$name]['vertical_image'] === 'on') {
                    //         $class = 'vertical-image';
                    //     }
                    // }
                    ?>
                    <div class="owl-carousel also-like-carousel owl-theme">
                        @foreach ($episodeInfo as $data)
                            <div class="card item margin-top-40">

                                {{-- favorite btn --}}
                                @if (!empty(Auth()->id()))
                                    <?php
                                    $checked = '';
                                    if (in_array($data->id, $favoriteList)) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <div class="text-right">
                                        <input type="checkbox" class="video-id" name="video_id"
                                            value="{{ $data->id }}" {{ $checked }}>
                                    </div>

                                @endif
                                {{-- end favorite btn --}}

                                @if (!empty($data->thumbnail))
                                    <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $data->thumbnail }}"
                                        alt="{{ $data->title }}" title="{{ $data->title }}" />
                                @else
                                    <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">{{ $data->title }}</h4>
                                    <p class="card-text">
                                        {{ $data->description }}
                                    </p>
                                    <a class="btn btn-primary mt-20" href="/frontend/videoshow/{{ $data->id }}">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                        Watch Movie
                                    </a>
                                </div>
                            </div>

                            {{-- native ads (for series) --}}
                            @if (!$adsInfo->isEmpty())
                                @foreach ($adsInfo as $ads)
                                    @if ($ads->ad_type === 'native_series')
                                        @if ($ads->status === 'on')
                                            @if ($count % ($ads->show_per_video_category ?? 1) === 0)
                                                <div class="card item margin-top-40 ads">
                                                    <div class="card-body">
                                                        {{ $ads->ad_link ?? '' }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif

                                    @if ($ads->ad_type === 'custom_native_series')
                                        @if ($ads->status === 'on')
                                            @if ($count % ($ads->show_per_video_category ?? '1') === 0)
                                                <div class="card item margin-top-40 ads">
                                                    <div class="card-body">
                                                        <a href="{{ $ads->ad_link ?? '' }}" class="custom-ads-link">
                                                            @if (!empty($ads->image))
                                                                <img src="{{ URL::to('/') }}/uploads/ad/{{ $ads->image }}"
                                                                    alt="{{ $ads->ad_type }}"
                                                                    title="{{ $ads->ad_type }}" />
                                                            @else
                                                                <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            {{-- native ads (for series) --}}
                            <?php
                            // if (!empty($settingsData[$name])) {
                            //     if ($count === $settingsData[$name]['video_number'] && $settingsData[$name]['video_number'] !== '0') {
                            //         break;
                            //     }
                            // }
                            $count++;
                            ?>
                        @endforeach
                    </div>
                    <!--/.Slides-->
                </div>
            @endif
            {{-- just added --}}

        </div>
    @endif
    {{-- end:: series content --}}

    {{-- Start:: You May Also Like video --}}
    <div class="container my-4 also-like">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-section-title">
                    <div class="title">
                        You May Also Like
                    </div>
                    <div class="triangle"></div>
                    <div class="line"></div>
                </div>
            </div>
        </div>
        <!--Slides-->
        <?php
        $count = '1';
        // $class = 'horizontal-image';
        // if (!empty($settingsData[$name])) {
        //     if ($settingsData[$name]['vertical_image'] === 'on') {
        //         $class = 'vertical-image';
        //     }
        // }
        ?>
        <div class="owl-carousel also-like-carousel owl-theme">
            @if (!$youLikeVideo->isEmpty())
                @foreach ($youLikeVideo as $data)
                    <div class="card item margin-top-40">

                        {{-- favorite btn --}}
                        @if (!empty(Auth()->id()))
                            <?php
                            $checked = '';
                            if (in_array($data->id, $favoriteList)) {
                                $checked = 'checked';
                            }
                            ?>
                            <div class="text-right">
                                <input type="checkbox" class="video-id" name="video_id" value="{{ $data->id }}"
                                    {{ $checked }}>
                            </div>

                        @endif
                        {{-- end favorite btn --}}

                        @if (!empty($data->thumbnail))
                            <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $data->thumbnail }}"
                                alt="{{ $data->title }}" title="{{ $data->title }}" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->title }}</h4>
                            <p class="card-text">
                                {{ $data->description }}
                            </p>
                            <a class="btn btn-primary mt-20" href="/frontend/videoshow/{{ $data->id }}">
                                <i class="fa fa-play" aria-hidden="true"></i>
                                Watch Movie
                            </a>
                        </div>
                    </div>


                    {{-- native ads (you may also like) --}}
                    @if (!$adsInfo->isEmpty())
                        @foreach ($adsInfo as $ads)
                            @if ($ads->ad_type === 'native_like')
                                @if ($ads->status === 'on')
                                    @if ($count % ($ads->show_per_video_category ?? 1) === 0)
                                        <div class="card item margin-top-40 ads">
                                            <div class="card-body">
                                                {{ $ads->ad_link ?? '' }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif

                            @if ($ads->ad_type === 'custom_native_like')
                                @if ($ads->status === 'on')
                                    @if ($count % ($ads->show_per_video_category ?? '1') === 0)
                                        <div class="card item margin-top-40 ads">
                                            <div class="card-body">
                                                <a href="{{ $ads->ad_link ?? '' }}" class="custom-ads-link">
                                                    @if (!empty($ads->image))
                                                        <img src="{{ URL::to('/') }}/uploads/ad/{{ $ads->image }}"
                                                            alt="{{ $ads->ad_type }}" title="{{ $ads->ad_type }}" />
                                                    @else
                                                        <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endif
                    {{-- native ads (you may also like) --}}
                    <?php
                    // if (!empty($settingsData[$name])) {
                    //     if ($count === $settingsData[$name]['video_number'] && $settingsData[$name]['video_number'] !== '0') {
                    //         break;
                    //     }
                    // }
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

        // add favorite
        $(document).on("change", ".video-id", function(e) {
            e.preventDefault();
            var id = $(this).val();
            var status = 'unchecked';
            if (this.checked == true) {
                status = 'checked';
            }

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };

            $.ajax({
                url: "{{ URL::to('video/add-favorite') }}",
                type: 'POST',
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    video_id: id,
                    status: status,
                },
                success: function(res) {
                    toastr.success(res.message, res, options);
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

        // get episode
        $(document).on("change", "#seasonType", function(e) {
            e.preventDefault();
            var id = $(this).val();
            $("#episodeData").html('');
            // alert(id);

            $.ajax({
                url: "{{ URL::to('frontend/get-episod') }}",
                type: 'POST',
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    season_id: id,
                },
                success: function(res) {
                    $("#episodeData").html(res.html);
                },
                error: function(jqXhr, ajaxOptions, thrownError) {}
            });
        });


        // comment add
        $(document).on("click", "#createComment", function(e) {
            e.preventDefault();
            var formData = new FormData($('#commentCreateForm')[0]);

            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null
            };
            $.ajax({
                url: "{{ URL::to('comment/store') }}",
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(res) {
                    toastr.success('Comment Added successfully', res, options);
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
