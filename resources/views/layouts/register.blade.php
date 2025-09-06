<!doctype html>
<html lang="en">
  <head>
    <title>Sign Up | {{ env('APP_NAME')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    </head>
    <body>
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
              <!-- Bagian ini dihilangkan sesuai permintaan -->
              <div class="img" style="background-image: url({{ asset('img/Logo_SILAU.png')}});"></div>
              <div class="login-wrap p-4 p-md-5">
                <div class="d-flex">
                  <div class="w-100">
                    <h3 class="mb-4">Register</h3>
                  </div>
                  <div class="w-100">
                    <p class="social-media d-flex justify-content-end">
                      <a href="{{ route('login')}}" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-arrow-left"></span></a>
                    </p>
                  </div>
                </div>
                <form action="{{ route('register') }}" method="POST" class="signin-form" autocomplete="off">
                  @csrf
                  <div class="form-group mb-3">
                    <label class="label" for="name">Nama</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                  </div>
                  <div class="form-group mb-3">
                    <label class="label" for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required autocomplete="off">
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group mb-3">
                    <label class="label" for="password">Password</label>
                    <div class="input-group mb-3">
							    	<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
							    	<div class="input-group-append">
							        	    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
							        	        <i class="fa fa-eye"></i>
							        	    </span>
							        	</div>
								    </div>
                    @error('password')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
                  </div>
                </form>
                <p class="text-center">Sudah punya akun? <a data-toggle="tab" href="{{ route('login') }}">Sign In</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  <script>
    	  const togglePassword = document.querySelector('#togglePassword');
	  const password = document.querySelector('#password');
	  
	  togglePassword.addEventListener('click', function () {
	      // toggle type password/text
	      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
	      password.setAttribute('type', type);
	      // toggle icon
	      this.querySelector('i').classList.toggle('fa-eye');
	      this.querySelector('i').classList.toggle('fa-eye-slash');
	  });
  </script>
  

    </body>
</html>