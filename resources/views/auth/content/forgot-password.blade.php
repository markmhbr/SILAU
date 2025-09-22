@extends('auth.auth')

@section('title', 'Lupa Password')

@section('content')

    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-key"></i></h1>
            <p>Lupa Password</p>
        </div>

        <div id="message" class="message"></div>

        <form action="{{ route('password.email') }}" method="POST" id="forgotForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
                <i class="fas fa-envelope"></i>
            </div>

            <button type="submit" class="login-btn">
                <span>Kirim Link Reset</span>
                <div class="spinner"></div>
            </button>
        </form>

        <div class="signup-link">
            <p><a href="{{ route('login') }}">Kembali ke Login</a></p>
        </div>
    </div>

    <script>
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const firstError = Object.values(@json($errors->getMessages()))[0][0];
                showMessage(firstError, 'error');
            });
        @endif

        @if (session('status'))
            document.addEventListener('DOMContentLoaded', function() {
                showMessage("{{ session('status') }}", 'success');
            });
        @endif

        function showMessage(text, type) {
            const messageEl = document.getElementById('message');
            messageEl.textContent = text;
            messageEl.className = `message ${type}`;
            messageEl.style.display = 'block';
            setTimeout(() => { messageEl.style.display = 'none'; }, 3000);
        }
    </script>

@endsection
