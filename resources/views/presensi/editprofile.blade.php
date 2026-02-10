@extends('layouts.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profile</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:4rem;">
        <div class="col">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <form action="/presensi/{{ $karyawan->nik }}/updateprofile" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap"
                        placeholder="Nama Lengkap" autocomplete="off">
                </div>
            </div>

            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text" class="form-control" value="{{ $karyawan->no_hp }}" name="no_hp"
                        placeholder="No. HP" autocomplete="off">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group boxed">
                <div class="input-wrapper password-wrapper">
                    <input type="password" name="password" id="password_edit" class="form-control" placeholder="Password">
                    <span class="toggle-password"
                        style="position: absolute; top: 60%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                        data-target="#password_edit">
                        <ion-icon name="eye-outline" class="icon-eye"></ion-icon>
                    </span>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group boxed">
                <div class="input-wrapper password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation_edit" class="form-control"
                        placeholder="Konfirmasi Password">
                    <span class="toggle-password"
                        style="position: absolute; top: 60%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                        data-target="#password_confirmation_edit">
                        <ion-icon name="eye-outline" class="icon-eye"></ion-icon>
                    </span>
                </div>
            </div>

            <div class="custom-file-upload" id="fileUpload1">
                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline"></ion-icon>
                            <i>Tap to Upload</i>
                        </strong>
                    </span>
                </label>
            </div>

            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="refresh-outline"></ion-icon> Update
                    </button>
                </div>
            </div>
        </div>
    </form>

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

        /* Hapus icon bawaan browser */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            display: none !important;
            pointer-events: none;
            position: absolute;
            right: -9999px;
        }
    </style>

    @push('passwordscript')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const toggleIcons = document.querySelectorAll('.toggle-password');

                toggleIcons.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const input = document.querySelector(this.dataset.target);
                        const icon = this.querySelector('ion-icon');

                        if (!input || !icon) return;

                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        icon.name = isPassword ? 'eye-off-outline' : 'eye-outline';
                    });
                });
            });
        </script>
    @endpush

@endsection
