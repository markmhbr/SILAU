<!DOCTYPE html>
@extends('auth.auth')

@section('title', 'Lupa Password')

@section('content')

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

    <!-- Register Container -->
    <div class="register-container">
        <div class="register-header">
            <h1><i class="fas fa-user-plus"></i></h1>
            <p>Buat Akun Baru</p>
        </div>

        <!-- Message Display -->
        <div id="message" class="message"></div>

        <!-- Register Form -->
        <form id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                <i class="fas fa-user"></i>
                @error('name')
                    <div class="validation-error" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email Anda" value="{{ old('email') }}" required>
                <i class="fas fa-envelope"></i>
                @error('email')
                    <div class="validation-error" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock"></i>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </span>
                @error('password')
                    <div class="validation-error" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="register-btn" id="registerBtn">
                <span id="btnText">Daftar</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>

        <div class="login-link">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
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
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const registerBtn = document.getElementById('registerBtn');
            const formData = new FormData(this);
            
            // Show loading
            btnText.style.display = 'none';
            spinner.style.display = 'block';
            registerBtn.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
                    }
                });
                
                // Check if response is redirect (non-AJAX response)
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                
                // Try to parse JSON response
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    // If not JSON, it's probably a redirect
                    window.location.reload();
                    return;
                }
                
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
                    registerBtn.disabled = false;
                }
            } catch (error) {
                showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
                
                // Reset button
                btnText.style.display = 'block';
                spinner.style.display = 'none';
                registerBtn.disabled = false;
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
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showMessage("{{ session('success') }}", 'success');
            });
        @endif
    </script>
@endsection