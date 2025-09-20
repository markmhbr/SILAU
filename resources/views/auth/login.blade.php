<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Animated Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset( 'css/auth.css' )}}">

</head>
<body>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-user-circle"></i></h1>
            <p>Selamat Datang Kembali!</p>
        </div>

        <!-- Message Display -->
        <div id="message" class="message"></div>

        <!-- Login Form -->
        <form id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email Anda" value="{{ old('email') }}" required>
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock"></i>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </span>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
                <a href="{{ route('password.request')}}" class="forgot-password">Lupa password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <span id="btnText">Masuk</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>

        <div class="signup-link">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show Message
        function showMessage(text, type) {
            const messageEl = document.getElementById('message');
            messageEl.textContent = text;
            messageEl.className = `message ${type}`;
            messageEl.style.display = 'block';
            
            setTimeout(() => {
                messageEl.style.display = 'none';
            }, 3000);
        }

        // Form Submission with AJAX
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const loginBtn = document.getElementById('loginBtn');
            const formData = new FormData(this);
            
            // Show loading
            btnText.style.display = 'none';
            spinner.style.display = 'block';
            loginBtn.disabled = true;
            
            try {
                const response = await fetch('{{ route('login') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Wait for 1.5 seconds before redirect
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    // Show error message
                    showMessage(data.message, 'error');
                    
                    // Reset button
                    btnText.style.display = 'block';
                    spinner.style.display = 'none';
                    loginBtn.disabled = false;
                }

                
            } catch (error) {
                showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
                
                // Reset button
                btnText.style.display = 'block';
                spinner.style.display = 'none';
                loginBtn.disabled = false;
            }
        });

        // Add input animations
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Display Laravel validation errors if any (for non-AJAX requests)
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const firstError = Object.values({{ $errors->getMessages() }})[0][0];
                showMessage(firstError, 'error');
            });
        @endif

        // Display Laravel status messages if any
        @if (session('status'))
            document.addEventListener('DOMContentLoaded', function() {
                showMessage("{{ session('status') }}", 'success');
            });
        @endif
    </script>
</body>
</html>