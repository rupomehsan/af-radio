@extends('frontend.layouts.client.index')
@section('content')
    @include('frontend.partials.client.slider')
    @if ($bannarInfo->isEmpty())
    <div class="margin-top-140"></div>
    @endif

    {{-- trending now --}}
    @if (!$trendingVideoInfo->isEmpty())
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="content-section-title">
                        <div class="title">
                            Trending Now
                        </div>
                        <div class="triangle"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>

            <!--Slides-->
            <?php
            $count = '1';
            $class = 'horizontal-image';
            if (!empty($settingsData['trending now'])) {
                if ($settingsData['trending now']['vertical_image'] === 'on') {
                    $class = 'vertical-image';
                }
            }
            ?>
            <div class="owl-carousel just-added-carousel owl-theme">
                @foreach ($trendingVideoInfo as $data)
                    <div class="card item margin-top-40">
                        <?php
                        $img = $data->thumbnail;
                        if (!empty($settingsData['trending now'])) {
                            if ($settingsData['trending now']['vertical_image'] === 'on') {
                                $img = $data->thumbnail_vertical;
                            }
                        }
                        ?>
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

                        @if (!empty($img))
                            <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $img }}"
                                alt="{{ $data->title }}" title="{{ $data->title }}" class="{{ $class }}" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" class="{{ $class }}" />
                        @endif

                        <a class="card-action" href="/frontend/videoshow/{{ $data->id }}"><i class="fa fa-play"
                                aria-hidden="true"></i></a>
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->title }}</h4>
                            <p class="card-text">
                                {{ $data->description }}
                            </p>
                        </div>
                    </div>

                    {{-- after category Ads --}}
                    @if (!$adsInfo->isEmpty())
                        @foreach ($adsInfo as $ads)
                            @if ($ads->ad_type === 'after_category')
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

                            @if ($ads->ad_type === 'custom_after_category')
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
                    {{-- after category Ads --}}

                    <?php
                    if (!empty($settingsData['trending now'])) {
                        if ($count === $settingsData['trending now']['video_number'] && $settingsData['trending now']['video_number'] !== '0') {
                            break;
                        }
                    }
                    $count++;
                    ?>
                @endforeach
            </div>
            <!--/.Slides-->
        </div>
    @endif
    {{-- trending now --}}


    {{-- just added --}}
    @if (!$justAdded->isEmpty())
        <div class="container mt-100">

            <div class="row">
                <div class="col-lg-12">
                    <div class="content-section-title">
                        <div class="title">
                            Just Added
                        </div>
                        <div class="triangle"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>

            <!--Slides-->
            <?php
            $count = '1';
            $class = 'horizontal-image';
            if (!empty($settingsData['just added'])) {
                if ($settingsData['just added']['vertical_image'] === 'on') {
                    $class = 'vertical-image';
                }
            }
            ?>
            <div class="owl-carousel just-added-carousel owl-theme">
                @foreach ($justAdded as $data)
                    <div class="card item margin-top-40">
                        <?php
                        $img = $data->thumbnail;
                        if (!empty($settingsData['just added'])) {
                            if ($settingsData['just added']['vertical_image'] === 'on') {
                                $img = $data->thumbnail_vertical;
                            }
                        }
                        ?>
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

                        @if (!empty($img))
                            <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $img }}"
                                alt="{{ $data->title }}" title="{{ $data->title }}" class="{{ $class }}" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" class="{{ $class }}" />
                        @endif

                        <a class="card-action" href="/frontend/videoshow/{{ $data->id }}"><i class="fa fa-play"
                                aria-hidden="true"></i></a>
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->title }}</h4>
                            <p class="card-text">
                                {{ $data->description }}
                            </p>
                        </div>
                    </div>

                    {{-- after category Ads --}}
                    @if (!$adsInfo->isEmpty())
                        @foreach ($adsInfo as $ads)
                            @if ($ads->ad_type === 'after_category')
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

                            @if ($ads->ad_type === 'custom_after_category')
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
                    {{-- after category Ads --}}
                    <?php
                    if (!empty($settingsData['just added'])) {
                        if ($count === $settingsData['just added']['video_number'] && $settingsData['just added']['video_number'] !== '0') {
                            break;
                        }
                    }
                    $count++;
                    ?>
                @endforeach
            </div>
            <!--/.Slides-->
        </div>
    @endif
    {{-- just added --}}

    {{-- sponsor image --}}
    @if (!$sponsorInfo->isEmpty())
        <div class="container mt-100">

            <div class="row">
                <div class="col-lg-12">
                    <div class="content-section-title">
                        <div class="title">
                            Sponsor Image
                        </div>
                        <div class="triangle"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            <!--Slides-->

            <div class="owl-carousel sponsor-carousel owl-theme">
                @foreach ($sponsorInfo as $sponsor)
                    @if ($sponsor->banner_type === 'image')

                        <div class="card item margin-top-40">
                            <a height="100%" href="{{ $sponsor->sponsor_url }}">
                                @if (!empty($sponsor->sponsor_image))
                                    <img height="100%"
                                        src="{{ URL::to('/') }}/uploads/sponsor/{{ $sponsor->sponsor_image }}"
                                        alt="{{ $sponsor->sponsor_title }}" title="{{ $sponsor->sponsor_title }}" />
                                @else
                                    <img height="100%" src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                @endif
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            <!--/.Slides-->
        </div>
    @endif
    {{-- sponsor image --}}


    <!-- popular video section start -->
    <section class="video mt-100">
        <div class="container">
            <div class="pupular">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="content-section-title-right">
                            <div class="title-right">
                                Popular
                            </div>
                            <div class="triangle-right"></div>
                            <div class="line-right"></div>
                        </div>
                    </div>
                </div>

                <!--Carousel Wrapper-->
                <div id="multi-item-example3" class="carousel slide carousel-multi-item ptb-90" data-ride="carousel">

                    <!--Controls-->
                    <div class="controls-top">
                        <a class="btn-floating" href="#multi-item-example3" data-slide="prev"><i
                                class="fas fa-chevron-left"></i></a>
                        <a class="btn-floating" href="#multi-item-example3" data-slide="next"><i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                    <!--/.Controls-->

                    <!--Indicators-->
                    <ol class="carousel-indicators">
                        <li data-target="#multi-item-example3" data-slide-to="0" class="active"></li>
                        <li data-target="#multi-item-example3" data-slide-to="1"></li>

                    </ol>
                    <!--/.Indicators-->

                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">

                        <?php $status = 'active';
                        $i= 1; ?>

                        @foreach ($populerVideoInfo as $data)
                            <!--single slide-->
                            <div class="carousel-item {{ $status }}">
                                <div class="col-md-12" style="float:left">
                                    <div class="card mb-2">
                                        <div class="popupar-wrapper  mt-20">
                                            <div class="row">

                                                <div class="col-md-12 col-lg-6">
                                                    <div class="video-area" style="height: 500px">
                                                        @if (!empty($data->video))
                                                            <video width="100%" height="100%" controls>
                                                                <source
                                                                    src="{{ URL::to('/') }}/uploads/video/1636205353.Sort video LOVE FROM FREE FIRE like and subscribe (1).mp4"
                                                                    type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @else
                                                            {{-- <img width="100%" height="100%"
                                                                src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $data->thumbnail ?? '' }}"
                                                                alt="video" />
                                                            <a href="{{ $data->url ?? '' }}" class="popup-youtube">
                                                                <i class="icofont icofont-ui-play"></i>
                                                            </a> --}}
                                                            {!! $embededCode['populer'][$i] !!}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="row">
                                                        <div class="prpular-right">
                                                            <h4 class="ptb-20">{{ $data->title }}</h4>
                                                            <p class="card-text">{{ $data->description }}</p><br>

                                                            {{-- favorite btn --}}
                                                            @if (!empty(Auth()->id()))
                                                                <?php
                                                                $checked = '';
                                                                if (in_array($data->id, $favoriteList)) {
                                                                    $checked = 'checked';
                                                                }
                                                                ?>
                                                                <span class="text-right populer-checkbox">
                                                                    <input type="checkbox" class="video-id"
                                                                        id="videoId" name="video_id"
                                                                        value="{{ $data->id }}" {{ $checked }}>
                                                                    &nbsp;<label for="videoId">Add To Favourite</label>
                                                                </span>

                                                            @endif
                                                            {{-- end favorite btn --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $status = '';
                            $i++; ?>
                            <!--single slide-->
                        @endforeach

                        <!--Second slide-->
                        {{-- <div class="carousel-item">
                            <div class="col-md-12" style="float:left">
                                <div class="card mb-2">
                                    <div class="popupar-wrapper  mt-20">
                                        <div class="row">

                                            <div class="col-md-12 col-lg-6">
                                                <div class="video-area">
                                                    <img src="assets/img/video/video1.png" alt="video" />
                                                    <a href="https://www.youtube.com/watch?v=RZXnugbhw_4"
                                                        class="popup-youtube">
                                                        <i class="icofont icofont-ui-play"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="row">
                                                    <div class="prpular-right">
                                                        <h4 class="ptb-20">Money Heisttttt</h4>
                                                        <p class="card-text">Money Heist (Spanish: La casa de papel,
                                                            "The House of
                                                            Paper") is a
                                                            Spanish heist crime drama television series created by Álex
                                                            Pina. The
                                                            series traces
                                                            two
                                                            long-prepared heists led by the Professor (Álvaro Morte), one on
                                                            the
                                                            Royal Mint of
                                                            Spain, and one on the Bank of Spain, told from the perspective
                                                            of one of
                                                            the
                                                            robbers,
                                                            Tokyo (Úrsula Corberó). The narrative is told in a
                                                            real-time-like
                                                            fashion and relies
                                                            on
                                                            flashbacks, time-jumps, hidden character motivations, and an
                                                            unreliable
                                                            narrator for
                                                            complexity.

                                                            The series was initially intended as a limited series to be told
                                                            in two
                                                            parts. It
                                                            had
                                                            its original run of 15 episodes on Spanish network Antena 3 from
                                                            2 May
                                                            2017 through
                                                            23
                                                            November 2017. Netflix acquired global streaming rights in late
                                                            2017. It
                                                            re-cut the
                                                            series into 22 shorter episodes and released them worldwide,
                                                            beginning
                                                            with the
                                                            first
                                                            part on 20 December 2017, followed by the second part on 6 April
                                                            2018.
                                                            In April
                                                            2018,
                                                            Netflix renewed the series with a significantly increased budget
                                                            for 16
                                                            new episodes
                                                            total. Part 3, with eight episodes, was released on 19 July
                                                            2019. Part
                                                            4, also with
                                                            eight episodes, was released on 3 April 2020. A documentary
                                                            involving
                                                            the producers
                                                            and

                                                        </p>
                                                        <button class="addbtn"><i class="fas fa-heart mr-3"></i>
                                                            Add To
                                                            Fevorite</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!--/.Second slide-->
                    </div>
                    <!--/.Slides-->

                </div>
            </div>
        </div>
    </section>
    <!-- popular video section end -->



    {{-- category video content --}}
    @if (!empty($categoryShow))
        <?php $categorySerial = '1'; ?>
        @foreach ($categoryShow as $id => $name)
            <div class="container mt-100 ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content-section-title">
                            <div class="title">
                                {{ $name }}
                            </div>
                            <div class="triangle"></div>
                            <div class="line"></div>
                        </div>
                    </div>
                </div>

                <!--Slides-->
                <?php
                $count = '1';
                $class = 'horizontal-image';
                if (!empty($settingsData[$name])) {
                    if ($settingsData[$name]['vertical_image'] === 'on') {
                        $class = 'vertical-image';
                    }
                }
                ?>

                <div class="owl-carousel just-added-carousel owl-theme">
                    @foreach ($categoryVideoInfo as $data)
                        @if ($data->category_id == $id)
                            <div class="card item margin-top-40">
                                <?php
                                $img = $data->thumbnail;
                                if (!empty($settingsData[$name])) {
                                    if ($settingsData[$name]['vertical_image'] === 'on') {
                                        $img = $data->thumbnail_vertical;
                                    }
                                }
                                ?>

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

                                @if (!empty($img))
                                    <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $img }}"
                                        alt="{{ $data->title }}" title="{{ $data->title }}"
                                        class="{{ $class }}" />
                                @else
                                    <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" class="{{ $class }}" />
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

                            {{-- after category Ads --}}
                            @if (!$adsInfo->isEmpty())
                                @foreach ($adsInfo as $ads)
                                    @if ($ads->ad_type === 'after_category')
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

                                    @if ($ads->ad_type === 'custom_after_category')
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
                            {{-- after category Ads --}}
                            <?php
                            if (!empty($settingsData[$name])) {
                                if ($count === $settingsData[$name]['video_number'] && $settingsData[$name]['video_number'] !== '0') {
                                    break;
                                }
                            }
                            $count++;
                            ?>
                        @endif
                    @endforeach
                </div>
                <!--/.Slides-->


                {{-- sponsor video --}}
                @if ($categorySerial == '1' && !$sponsorInfo->isEmpty())
                    <div class="mt-100">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="content-section-title">
                                    <div class="title">
                                        Sponsor Video
                                    </div>
                                    <div class="triangle"></div>
                                    <div class="line"></div>
                                </div>
                            </div>
                        </div>
                        <!--Slides-->
                        <div class="owl-carousel sponsor-carousel owl-theme">
                            <?php $i=1;?>
                            @foreach ($sponsorInfo as $sponsor)

                                @if ($sponsor->banner_type === 'video')
                                    <div class="card item margin-top-40">

                                        @if (!empty($sponsor->local_video))
                                            <video width="100%" height="100%" controls>
                                                <source
                                                    src="{{ URL::to('/') }}/uploads/video/1636205353.Sort video LOVE FROM FREE FIRE like and subscribe (1).mp4"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            {{-- <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $sponsor->video_thumbnail ?? '' }}"
                                                alt="video" />
                                            <a href="{{ $sponsor->video_url ?? '' }}" class="popup-youtube">
                                                <i class="icofont icofont-ui-play"></i>
                                            </a> --}}

                                            {!! $embededCode['sponsor'][$i] !!}
                                        @endif
                                    </div>
                                @endif
                                <?php $i++;?>
                            @endforeach
                        </div>
                        <!--/.Slides-->
                    </div>
                @endif
                {{-- sponsor Video --}}

                {{-- after category Ads --}}
                {{-- @if (!$adsInfo->isEmpty())
                    @foreach ($adsInfo as $ads)
                        @if ($ads->ad_type === 'after_category')
                            @if ($ads->status === 'on')
                                @if ($categorySerial % ($ads->show_per_video_category ?? 1) === 0)
                                    <div class="ads-section margin-top-20" style="height: 300px">
                                        {{ $ads->ad_link ?? '' }}
                                    </div>
                                @endif
                            @endif
                        @endif

                        @if ($ads->ad_type === 'custom_after_category')
                            @if ($ads->status === 'on')
                                @if ($categorySerial % ($ads->show_per_video_category ?? '1') === 0)
                                    <div class="ads-section margin-top-20" style="height: 300px">
                                        <a href="{{ $ads->ad_link ?? '' }}" class="custom-ads-link">
                                            @if (!empty($ads->image))
                                                <img src="{{ URL::to('/') }}/uploads/ad/{{ $ads->image }}"
                                                    alt="{{ $ads->ad_type }}" title="{{ $ads->ad_type }}" />
                                            @else
                                                <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif --}}
                {{-- after category Ads --}}
            </div>
            <?php $categorySerial++; ?>
        @endforeach
    @endif
    {{-- category video content --}}

@endsection

@push('custom-js')
    <script>
        $('.just-added-carousel').owlCarousel({
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

        $('.sponsor-carousel').owlCarousel({
            items: 2,
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
                    items: 1
                },
                1000: {
                    items: 2
                }
            }
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
    </script>
@endpush
