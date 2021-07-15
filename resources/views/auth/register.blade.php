<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Register</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('auth/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('auth/css/sb-admin-2.min.css') }}" rel="stylesheet">


</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-1 d-none d-lg-block bg-register-images"></div>
          <div class="col-lg-10">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Register</h1>
              </div>
              <form class="user" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror form-control-user" id="exampleFirstName" autocomplete="off" placeholder="Nama">
                    @error('name')
                    <div class="invalid-feedback ml-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control @error('username') is-invalid @enderror form-control-user" value="{{ old('username') }}" id="exampleLastName" autocomplete="off" name="username" placeholder="Username">
                    @error('username')
                    <div class="invalid-feedback ml-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control @error('email') is-invalid @enderror form-control-user" id="exampleInputEmail" value="{{ old('email') }}" autocomplete="off" name="email" placeholder="Email">
                  @error('email')
                    <div class="invalid-feedback ml-3">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control @error('password') is-invalid @enderror form-control-user" id="exampleInputPassword" autocomplete="off" name="password" placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback ml-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror form-control-user" id="exampleRepeatPassword" autocomplete="off" name="password_confirmation" placeholder="Konfirmasi password">
                    @error('password_confirmation')
                    <div class="invalid-feedback ml-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Register
                </button>
                <hr>
                <a href="{{ route('login') }}" class="btn btn-google btn-user btn-block">
                 Login
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('auth/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('auth/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('auth/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('auth/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
