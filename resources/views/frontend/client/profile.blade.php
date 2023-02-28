@extends('frontend.layouts.client.index')
@section('content')
    <!-- video section start -->
    <section class="video ptb-90">
        <div class="row">
            <div class="col-md-6 text-center profile-image">
                @if (!empty($profile->image))
                    <img src="{{ URL::to('/') }}/uploads/user/{{ $profile->image }}"
                        alt="{{ $profile->name }}" title="{{ $profile->name }}" />
                @else
                    <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" />
                @endif
            </div>
            <div class="col-md-6 profile-info">
                <h2 class="margin-top-40">{{$profile->name ?? ''}}</h2> <a href="/frontend/edit-profile" class="edit-profile"><i class="fas fa-edit"></i></a>
                <div class="margin-top-20 profile-info-detail"><i class="fas fa-phone-alt"></i>&nbsp; Phone No : {{$profile->phone ?? ''}}</div>
                <div class="margin-top-20 profile-info-detail"><i class="far fa-envelope"></i>&nbsp; Email : {{$profile->email ?? ''}}</div>
            </div>
            <div class="col-md-6 text-center">
            </div>
        </div>
    </section>
    <!-- video section end -->


@endsection
@push('custom-js')
    <script>
    </script>
@endpush
