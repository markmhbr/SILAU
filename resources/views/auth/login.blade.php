<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SILAU | Login</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
    body {
      background-color: #80aeb2 !important; /* warna background sesuai contoh */
    }
    .login-page {
      display: flex;
      align-items: center;
      justify-content: space-between;
      min-height: 100vh;
      padding: 20px;
    }
    .left-img {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .left-img img {
      max-width: 350px;
    }
    .login-box {
      flex: 1;
      max-width: 400px;
    }
    .logo-text {
      text-align: left;
      margin-bottom: 30px;
    }
    .logo-text h2 {
      margin: 0;
      font-weight: bold;
    }
    .logo-text span {
      font-size: 13px;
      color: #333;
    }
    .login-card-body {
      border-radius: 12px;
    }
    .btn-login {
      background-color: #1d7727;
      border: none;
    }
    .btn-login:hover {
      background-color: #14541b;
    }
    .user-icon {
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 22px;
      color: #111;
      cursor: pointer;
    }
  </style>
</head>
<body class="hold-transition login-page">

  <!-- Icon user pojok kanan -->
  <div class="user-icon">
    <i class="fas fa-user-plus"></i>
  </div>

  <div class="left-img">
    <img src="{{ asset('images/mesin-cuci.png') }}" alt="Laundry Illustration">
  </div>

  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">

        <!-- Logo -->
        <div class="logo-text">
          <h2>SILAU</h2>
          <span>Sistem Informasi Laundry</span>
        </div>

        <form action="" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 text-right">
              <a href="">buat akun?</a>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <button type="submit" class="btn btn-login btn-block text-white">login</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
