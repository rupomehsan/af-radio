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
    @endforeach
</div>
<!--/.Slides-->
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
</script>
