@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
    <div class="content-heading">
        <div class="row">
            {{-- title --}}
            <div class="col-md-8 content-title">
                <span class="title">Manage Admin</span>
                <a class="create-button" href="{{url('/admin/admin/create')}}">
                    <span class="iconify" data-icon="bi:plus-circle-fill"></span>Add Admin
                </a>
                <div class="title-line"></div>
            </div>
            {{-- title --}}

            {{-- search --}}
            <div class="col-md-4 text-right">
                <form action="{{url('/admin/admin/super-admin/filter')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group content-search">
                        <button class="input-group-text search" id="addon-wrapping">
                            <span class="iconify" data-icon="bx:bx-search"></span>
                        </button>
                        <input name="fil_search" type="text" class="form-control search" placeholder="Search" aria-label="fil_search">
                    </div>
                </form>
            </div>
            {{-- search --}}

        </div>


        <div class="row margin-top-20">
            <div class="col-md-1 content-title">
                <span class="">
                    <a href="{{url('/admin/admin')}}" class="title-btn ">Admin</a>
                </span>
                <div class="title-line display-none"></div>
            </div>
            <div class="col-md-2 content-title">
                <span class="">
                    <a href="{{url('/admin/admin/super-admin')}}" class="title-btn">Super Admin</a>
                </span>
                <div class="title-line"></div>
            </div>
        </div>
    </div>
    {{-- End:: content heading --}}

    <?php
$ses_msg = Session::has('success');
if (!empty($ses_msg)) {
    ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('success'); ?></p>
    </div>
    <?php
} //
$ses_msg = Session::has('error');
if (!empty($ses_msg)) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('error'); ?></p>
    </div>
    <?php
} // ?>
    {{-- Start::Content Body --}}

    <div class="row margin-top-40 content-details">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="text-center">SERIAL</th>
                    <th scope="col" class="text-center">IMAGE</th>
                    <th scope="col" class="text-center">NAME</th>
                    <th scope="col" class="text-center">PHONE NO</th>
                    <th scope="col" class="text-center">EMAIL</th>
                    <th scope="col" class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl = 1;?>
                @if (!$target->isEmpty())
                    @foreach ($target as $data)
                        <tr>
                            <th class="text-center" scope="row">{{ $sl++ }}</th>
                            <td class="text-center table-image">
                                @if (!empty($data->image))
                                    <img src="{{ URL::to('/') }}/uploads/user/{{ $data->image }}"
                                        alt="{{ $data->name }}" title="{{ $data->name }}" />
                                @else
                                    <img class="border" src="{{ asset('assets/img/dummy.jpg')}}" alt="" />
                                @endif
                            </td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->phone }}</td>
                            <td class="text-center">{{ $data->email }}</td>
                            <td class="table-actions text-center">

                                    <a href="{{ URL::to('admin/admin/' . $data->id . '/edit') }}">EDIT</a>
                                    <button type="submit" class="" onclick="deleteItem('{{ URL::to('admin/admin/' . $data->id) }}')" title="Delete">DELETE</button>


                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <nav class="page-navigation d-flex justify-content-center py-3 ">
            {{$target->links()}}
        </nav>
    </div>
    {{-- End::Content Body --}}


@stop
@push('custom-js')
    <script type="text/javascript">

    </script>
@endpush
