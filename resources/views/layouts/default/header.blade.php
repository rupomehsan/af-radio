<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = \App\Models\Setting::first();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if ($title && $title->logo)
        <link rel="shortcut icon" type="image/jpg" href="{{ URL::to('/') }}/uploads/{{ $title->logo }}"/>
    @endif
    @if ($title && $title->system_name)
        <title>{{ $title->system_name }}</title>
    @else
        <title>Radio App</title>
    @endif

    <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/nice-select.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/autoComplete.01.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/placeholder-loading.min.css')}}"/>
    <!-- <link rel="stylesheet" href="{{asset('assets/css/avnSkeleton.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/gijgo.min.css')}}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.3/filepond.min.css"--}}
{{--          integrity="sha512-Zgp/CdUqOMnAY0ReSgoyZ2rk7CBVP0TqF+nTxDRo/mS0WEfQ+GOAaQDgHemhvd/C4rNrACYF/wyDqEYxhSN9dQ=="--}}
{{--          crossorigin="anonymous" referrerpolicy="no-referrer"/>--}}
    {{--        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>--}}
    {{--    <script src="https://use.fontawesome.com/dcd31f63af.js"></script>--}}
    {{--    <script src="https://kit.fontawesome.com/ab8915b796.js" crossorigin="anonymous"></script>--}}
</head>
<div id="preloader" class="d-none">
    <div id="status">
    </div>
</div>
