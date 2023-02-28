@include('layouts.default.header')

<body>

    <div class="full-body">
        <div class="container-fluid">
            <div class="row">
                @include('layouts.default.sidebar')
                <div class="main-body  col-md-10  col-sm-12 col-12">
                    @include('layouts.default.topNavbar')
                    <div class="togglebtn" id="sideBarHide">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </div>
                    <div class="content-body">
                        @yield('data_count')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.default.footerScript')
</body>

</html>
