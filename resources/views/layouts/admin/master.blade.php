<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('admin/img/icon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('admin/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/atlantis.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/sweetalert-2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/animate-css/animate.min.css') }}">
    @stack('css')

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('admin/css/demo.css') }}">
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="animate__animated animate__bounceInUp logo-header" data-background-color="blue">

                <a href="index.html" class="logo">
                    <img src="{{ asset('admin/img/logo.svg') }}" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            @include('layouts.admin._navbar')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('layouts.admin._sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">

            @yield('admin-content')

            @include('layouts.admin._footer')

        </div>
    </div>

    {{-- Modal logout user --}}
    @auth
    <div class="modal fade modal-logout" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('post')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <p class="text-capitalize">Apakah anda ingin logout?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-uppercase btn btn-danger"
                            data-dismiss="modal">Batal</button>
                        <button type="submit"
                            class="none btn-save text-uppercase btn d-flex btn-primary">Ya</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endauth
    
    <!--   Core JS Files   -->
    <script src="{{ asset('admin/js/core/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Sweet Alert -->
    @includeIf('include.sweetalert')

    <!-- Atlantis JS -->
    <script src="{{ asset('admin/js/atlantis.min.js') }}"></script>

    @stack('js')

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    {{-- <script src="{{ asset('admin/js/setting-demo.js') }}"></script> --}}

    <script>
        $(document).ready(function(){
            $('.dropdown-user').on('click','.btn-logout',function(e){
            e.preventDefault();
            console.log('ok');
            $('.modal-logout').modal('show');
        })
    });
    </script>
</body>

</html>
