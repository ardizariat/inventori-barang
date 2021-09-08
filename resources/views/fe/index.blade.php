<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Inventori</title>
  <link rel="icon" href="{{ $setting->getLogo() ?? '' }}" type="image/png">
  <!-- Bootstrap Icons-->
  <link rel="stylesheet" href="{{ asset('fe/css/bootstrap-icons.css') }}">
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
    rel="stylesheet" type="text/css" />
  <!-- SimpleLightbox plugin CSS-->
  <link rel="stylesheet" href="{{ asset('fe/css/simpleLightbox.min.css') }}">
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="{{ asset('fe/css/styles.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5">
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto my-2 my-lg-0">
          @auth
            <li class="nav-item"><a class="nav-link">{{ auth()->user()->name }}</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
  <!-- Masthead-->
  <header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
      <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-8 align-self-end">
          <h1 class="text-white text-capitalize font-weight-bold">
            selamat datang di aplikasi inventori
          </h1>
          <hr class="divider" />
        </div>
        <div class="col-lg-8 align-self-baseline">
          @auth
            <a class="btn btn-primary btn-xl" href="{{ route('dashboard.index') }}">Masuk Ke Sistem</a>
          @else
            <a class="btn btn-primary btn-xl" href="{{ route('login') }}">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </header>
  <!-- Footer-->
  <footer class="bg-light py-5">
    <div class="container px-4 px-lg-5">
      <div class="small text-center text-muted">Copyright &copy; {{ date('Y') }} - Ardi Nor Dzariat</div>
    </div>
  </footer>
  <!-- Bootstrap core JS-->
  <script src="{{ asset('fe/js/bootstrap.bundle.min.js') }}"></script>
  <!-- SimpleLightbox plugin JS-->
  <script src="{{ asset('fe/js/simpleLightbox.min.js') }}"></script>
  <!-- Core theme JS-->
  <script src="{{ asset('fe/js/scripts.js') }}"></script>
  <script src="{{ asset('fe/js/sb-forms-0.4.1.js') }}"></script>
</body>

</html>
