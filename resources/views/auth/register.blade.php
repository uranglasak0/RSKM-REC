@extends('layouts.auth')
@section('title', 'RSKM REC - Register')
@section('content')

    <div class="login-form mt-1">
        <div class="section">
            <h1>Register</h1>
            <h4>Silakan isi data di bawah</h4>
        </div>

        <div class="section mt-1 mb-5">
            @if (session('warning'))
                <div class="alert alert-outline-warning">
                    {{ session('warning') }}
                </div>
            @endif
            <form action="/register" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="0">Laki-laki</option>
                            <option value="1">Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Jabatan">
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="No. HP">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <span toggle="#password"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                            class="toggle-password">
                            <ion-icon name="eye-outline"></ion-icon>
                        </span>
                    </div>
                </div>
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
                            placeholder="Konfirmasi Password">
                        <span toggle="#password_confirmation"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                            class="toggle-password">
                            <ion-icon name="eye-outline"></ion-icon>
                        </span>
                    </div>
                </div>

                <div class="form-button-group">
                    <button type="submit" class="btn btn-orange btn-block btn-lg">Register</button>
                </div>
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
                if (value.length > 0 && !(isLengthValid && isUppercaseValid && isNumberValid &&
                        isSymbolValid)) {
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
