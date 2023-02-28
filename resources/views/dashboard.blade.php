@extends('layouts.default.master')
@section('data_count')
    {{-- Titles --}}
    {{-- <a href="{{url('/send-notification')}}">Send Notification</a> --}}


    <img src="{{ asset('img/Hello.png') }}" alt="Hello">
    <h4 class="margin-top-20">
        <span class="bold">Welcome</span> <span class="bold red">Onboard</span>
    </h4>
    <div class=" margin-top-20">
        <span class="red">User Overview</span>
        <div class="line margin-top-10"></div>
    </div>
    {{-- Titles --}}

    <div class="row">
        <div class="col-md-6 col-lg-8 col-sm-12 col-12 margin-top-20">
            {{-- Start:: Menu Carts --}}
            <div class="menu-carts ">
                <div class="row">
                    {{-- single cart --}}
                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold">{{ $totalActiveUser ?? '0' }}</h4>
                                <span class="cart-title">Total Live Now</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="material-symbols:category" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart mt-md-1 mt-sm-1 mt-xm-1">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold">{{ $totalUser ?? '0' }}</h4>
                                <span class="cart-title">Total User</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="bxs:user" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart mt-lg-1 mt-md-1 mt-sm-1 mt-xm-1">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold">{{ $totalLsHor ??'0' }}</h4>
                                <span class="cart-title">Listening Hours</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="bxs:radio" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- End:: Menu Carts --}}


            {{-- Start:: Visitors Count --}}
            <div class="visitors-count margin-top-40">
                <img src="{{ asset('img/graph.png') }}" alt="" style="width: 85%">
            </div>
            {{-- End:: Visitors Count --}}

        </div>
        <div class="col-md-6 col-lg-4 col-sm-12 col-12 ">
            {{-- Start::Right Top Cart --}}
            <div class="right-cart">
            {{-- End::Right Top Cart --}}

            {{-- Start:: Top Category Cart --}}
            <div class="top-category-cart margin-top-20">
                <span class="category-cart-title bold">Popular Station</span>
                <div class="row">
                    @forelse($countries as $country)
                        <div class="col-md-6  col-lg-4  col-sm-6 margin-top-20">
                            <div class="d-flex">
                                <div class="">
                                    @if (!empty($country['image']))
                                        <img src="{{ $country['image'] }}"
                                             alt="image" title="{{ $country['name'] }}" height="50" width="50"/>
                                    @else
                                        <img height="50" width="80" src="{{ asset('assets/img/dummy.jpg') }}" alt=""/>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="text-center">
                                        <span class="category-cart-content-title px-1">{{substr($country['name'],0,10)}}</span>
                                    </div>
                                    <div class="category-cart-content-number text-center">
                                        @if($country['growth'] > 0)
                                            <span class="iconify" data-icon="oi:caret-top"></span>
                                            +{{$country['growth']}}%
                                        @else
                                            <span class="iconify" data-icon="oi:caret-bottom"></span>
                                            {{$country['growth']}}%
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Data Found</p>
                    @endforelse

                </div>

            </div>




        </div>
    </div>
@stop
@push('custom-js')
    <script type="text/javascript">
        $(function () {

        });
    </script>
@endpush
