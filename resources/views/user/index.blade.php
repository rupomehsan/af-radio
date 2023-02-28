@extends('layouts.default.master')
@section('data_count')
    {{-- Start:: content heading --}}
    <div class="content-heading">
        <div class="row">
            {{-- title --}}
            <div class="col-md-8 content-title">
                <span class="title">Manage User</span>

                <a class="create-button" href="{{url('admin/user/create')}}">
                    <span class="iconify" data-icon="bi:plus-circle-fill"></span>Add User
                </a>
                <div class="title-line"></div>
            </div>
            {{-- title --}}

            {{-- search --}}
            <div class="col-md-4 text-right">
                <form action="{{url('/admin/user/filter')}}" method="POST" enctype="multipart/form-data">
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
}//
$ses_msg = Session::has('error');
if (!empty($ses_msg)) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('error'); ?></p>
    </div>
    <?php
}// ?>
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
                <?php $sl = 1; ?>
                @if (!$target->isEmpty())
                    @foreach ($target as $data)
                        <tr>
                            <th class="text-center" scope="row">{{ $sl++ }}</th>
                            <td class="text-center table-image">
                                @if (!empty($data->image))
                                    <img src="{{ $data->image }}"
                                        alt="{{ $data->name }}" title="{{ $data->name }}" />
                                @else
                                    <img class="border" src="{{ asset('assets/img/dummy.jpg') }}" alt="" />
                                @endif
                            </td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->phone }}</td>
                            <td class="text-center">{{ $data->email }}</td>
                            <td class="table-actions text-center">
                                    <a href="{{ URL::to('/admin/user/' . $data->id . '/edit') }}">EDIT</a>
                                    <button type="submit" onclick="deleteItem('user/{{$data->id}}')" class="" title="Delete">DELETE</button>
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
