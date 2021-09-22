<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>{{ $setting->nama_aplikasi ?? '' }} @yield('title')</title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="{{ $setting->getLogo() ?? '' }}" type="image/png">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
   <div class="container">
    <a class="navbar-brand text-white" href="#">
      <h3>
        <strong>
          {{ $setting->nama_aplikasi ?? 'Inventori' }}
        </strong>
      </h3>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          @auth
          <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ auth()->user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('profile-user.index') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('profile-user.edit') }}">Edit Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
            </a>
          </div>
          @endauth
        </li>
      </ul>
    </div>
   </div>
  </nav>

  <section>
    <div class="jumbotron jumbotron-fluid">
     <div class="container">
      <h1 class="mb-3 display-4 text-white text-center"><strong>Selamat datang</strong> di aplikasi 
        <br>
        <strong>inventori</strong> barang</h1>
        <a href="{{ route('dashboard.index') }}" class="text-white btn align-items-center btn-outline-primary tombol">         
          Masuk ke sistem 
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
          </svg>
        </a>
     </div>
    </div>
  </section>

  <script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>

</html>