<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Animated Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0f2a 0%, #1c1f2b 100%);
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: move 25s linear infinite;
            bottom: -150px;
        }

        .bg-animation span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .bg-animation span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .bg-animation span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-animation span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-animation span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .bg-animation span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .bg-animation span:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .bg-animation span:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(255, 228, 228, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: white;
            font-size: 2.5em;
            margin-bottom: 10px;
            animation: fadeInDown 0.8s ease-out;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1em;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .form-group input:focus + i {
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            color: white;
        }

        .remember-me {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
        }

        .forgot-password {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .forgot-password:hover {
            color: white;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0a0f2a 0%, #1c1f2b 50%, #2a2f3b 100%);
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Loading Spinner */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Sign Up Link */
        .signup-link {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.8);
        }

        .signup-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            text-decoration: underline;
            transform: scale(1.05);
            display: inline-block;
        }

        /* Error/Success Messages */
        .message {
            padding: 12px 20px;
            border-radius: 50px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            animation: slideInMessage 0.3s ease-out;
            display: none;
        }

        @keyframes slideInMessage {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.error {
            background: rgba(255, 59, 48, 0.2);
            border: 1px solid rgba(255, 59, 48, 0.5);
            color: #ff3b30;
        }

        .message.success {
            background: rgba(52, 199, 89, 0.2);
            border: 1px solid rgba(52, 199, 89, 0.5);
            color: #34c759;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

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
                <a href="" class="forgot-password">Lupa password?</a>
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