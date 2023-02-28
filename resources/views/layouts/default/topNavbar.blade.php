{{-- Start:: Top Header --}}

<?php
// $notificationNumber = \App\Models\Report::where('status', 'active')->where('view_status', 'pending')->count();
?>
<div class="top-header   text-right margin-top-10">
    <ul>
        {{-- <li>
            <a href="#" class="">
                <span class="iconify" data-icon="whh:headphonesalt" data-flip="horizontal"></span>
            </a>
        </li> --}}
        {{-- <li>
            <a href="/report" class="">
                <span class="iconify" data-icon="clarity:notification-line" data-flip="horizontal"></span>
                <span class="notification-number">{{$notificationNumber}}</span>
            </a>
        </li> --}}
        <li>
            <!-- Example single danger button -->
            <div class="btn-group">

                <div class="d-flex align-items-center justify-content-center">
                    <div>

                    @if (!empty(Auth::user()->image))
                        <img src="{{ Auth::user()->image }}"
                             alt="img" class="header-user-img" />
                    @else
                        <img  src="{{ asset('assets/img/dummy.jpg')}}" class="header-user-img border" />
                    @endif
                    </div>
                    <div class="mx-1">
                    {{Auth::user()->name}}

                    </div>

                </div>
                <button type="button" class="btn profile-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                        </button>

                <div class="dropdown-menu">
                    <a href="{{url('admin/profile')}}"> <span class="iconify" data-icon="healthicons:ui-user-profile"></span> My Profile</a> <br>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                        <span class="iconify" data-icon="carbon:logout"></span>  Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>


                </div>
            </div>


        </li>
    </ul>

</div>
{{-- End:: Top Header --}}
