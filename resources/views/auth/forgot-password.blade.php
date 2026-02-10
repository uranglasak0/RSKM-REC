@extends('layouts.auth')
@section('title', 'RSKM REC - Forgot Password')
@section('content')

    <div class="login-form mt-1">
        <div class="section">
            <h1>Lupa Password</h1>
            <h4>Masukkan NIK, No HP, dan Password Baru</h4>
        </div>

        <div class="section mt-1 mb-5">
            @if (session('warning'))
                <div class="alert alert-outline-warning">{{ session('warning') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="/forgot-password" method="POST">
                @csrf

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="nik" class="form-control" placeholder="NIK" required>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="no_hp" class="form-control" placeholder="No HP" required>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <span toggle="#password"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                            class="toggle-password">
                            <ion-icon name="eye-outline"></ion-icon>
                        </span>
                    </div>
                </div>
                {{-- Aturan Password --}}
                <div class="form-group boxed" id="password-rules-wrapper">
                    <div id="password-rules" style="font-size: 13px; margin-top: -0.5rem; margin-bottom: -0.5rem;">
                        <div id="rule-length" style="color: red;">Minimal 8 karakter</div>
                        <div id="rule-uppercase" style="color: red;">Mengandung huruf besar (A-Z)</div>
                        <div id="rule-number" style="color: red;">Mengandung angka (0-9)</div>
                        <div id="rule-symbol" style="color: red;">Mengandung simbol (!@#$%&*?)</div>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Password" required>
                        <span toggle="#password_confirmation"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                            class="toggle-password">
                            <ion-icon name="eye-outline"></ion-icon>
                        </span>
                    </div>
                </div>
                <div class="form-button-group">
                    <button type="submit" class="btn btn-orange btn-block btn-lg">Reset Password</button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-outline-danger">
                        @foreach ($errors->all() as $error)
                            <div style="font-size: 0.85rem">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>

@endsection

@push('ketpass')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const lengthRule = document.getElementById('rule-length');
            const uppercaseRule = document.getElementById('rule-uppercase');
            const numberRule = document.getElementById('rule-number');
            const symbolRule = document.getElementById('rule-symbol');
            const ruleWrapper = document.getElementById('password-rules-wrapper');

            // Awalnya disembunyikan
            ruleWrapper.classList.add('hidden');

            passwordInput.addEventListener('input', function() {
                const value = passwordInput.value;

                // Cek ketentuan password
                const isLengthValid = value.length >= 8;
                const isUppercaseValid = /[A-Z]/.test(value);
                const isNumberValid = /[0-9]/.test(value);
                const isSymbolValid = /[@$!%*#?&]/.test(value);

                // Update warna aturan
                lengthRule.style.color = isLengthValid ? 'green' : 'red';
                uppercaseRule.style.color = isUppercaseValid ? 'green' : 'red';
                numberRule.style.color = isNumberValid ? 'green' : 'red';
                symbolRule.style.color = isSymbolValid ? 'green' : 'red';

                // Tampilkan aturan jika user mulai mengetik
                if (value.length > 0 && !(isLengthValid && isUppercaseValid && isNumberValid && isSymbolValid)) {
                    ruleWrapper.classList.remove('hidden');
                } else {
                    ruleWrapper.classList.add('hidden');
                }
            });
        });
    </script>
@endpush


<style>
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }

    .toggle-password ion-icon {
        font-size: 1.2rem;
        color: #555;
    }

    /* Style aturan password agar tetap beri ruang */
    #password-rules {
        font-size: 13px;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        padding-left: 0;
        list-style-type: none;
        line-height: 1.4;
        transition: all 0.3s ease;
    }

    #password-rules-wrapper.hidden {
        display: none !important;
    }


    input[type="password"]::-ms-reveal,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
        pointer-events: none;
        position: absolute;
        right: -9999px;
    }
</style>


@push('myscript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-password');
            toggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('toggle'));
                    const icon = this.querySelector('ion-icon');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.name = "eye-off-outline";
                    } else {
                        input.type = 'password';
                        icon.name = "eye-outline";
                    }
                });
            });
        });
    </script>
@endpush
