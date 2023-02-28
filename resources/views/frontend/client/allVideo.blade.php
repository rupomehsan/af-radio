@extends('frontend.layouts.client.index')
@section('content')
    <!-- video section start -->
    <section class="video ptb-90 vidio-wrapper">
        <div class="container">
            <div class="vidio-banner ptb-30">
                @if (!empty($request->type))
                <h3 class="margin-top-20 all-video-title">{{$request->type}}</h3>
                @endif


                <div class="vidiobanner margin-top-20">
                    <img src="{{ asset('assets/img/vidio-banner.png') }}" alt="">
                    <p><span>10M</span> <b>Videos</b>
                        View More than 10 milions videos on xflix</p>
                </div>

            </div>

        </div>
    </section>
    <!-- video section end -->
    <div class="container">
        <div class="row">
            @if (!$videos->isEmpty())
                @foreach ($videos as $data)
                    <div class="col-md-6 col-lg-3 col-sm-6 col-6 margin-top-20">
                        <div class="card-sl">
                            <div class="card-image">
                                {{-- favorite btn --}}
                                @if (!empty(Auth()->id()))
                                    <?php
                                    $checked = '';
                                    if (in_array($data->id, $favoriteList)) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <span>
                                        <input type="checkbox" class="video-id" name="video_id"
                                            value="{{ $data->id }}" {{ $checked }}>
                                    </span>

                                @endif
                                {{-- end favorite btn --}}

                                @if (!empty($data->thumbnail))
                                    <img src="{{ URL::to('/') }}/uploads/video/thumbnail/{{ $data->thumbnail }}"
                                        alt="{{ $data->title }}" title="{{ $data->title }}" />
                                @else
                                    <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                                @endif

                                <a class="card-action" href="/frontend/videoshow/{{ $data->id }}"><i class="fa fa-play" aria-hidden="true"></i></a>
                            </div>

                            <h4 class="ptb-20 pb-2">{{ $data->title }}</h4>
                            <p>{{ $data->description }}</p>

                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@endsection

@push('custom-js')
    <script>
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
