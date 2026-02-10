<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>RSKM REC - E-Presensi</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('assets/img/login/login.jpg') }}" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1 style="margin-top: -50px;">RSKM</h1>
                <h1>Regina Eye Center</h1>
                <h4>Silahkan Login</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                    $messagewarning = Session::get('warning');
                @endphp
                @if (Session::has('warning'))
                    <div class="alert alert-outline-warning">
                        {{ $messagewarning }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-outline-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="/proseslogin" method="POST">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="nik" class="form-control" id="nik" placeholder="NIK">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper password-wrapper" style="position: relative;">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <!-- Icon Clear Input -->
                            <span class="clear-input"
                                style="position: absolute; top: 50%; right: 25px; transform: translateY(-50%); cursor: pointer;">
                                <ion-icon name="close-circle"></ion-icon>
                            </span>
                            <!-- Icon Show/Hide Password -->
                            <span class="toggle-password" data-target="#password"
                                style="position: absolute; top: 60%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                <ion-icon name="eye-outline"></ion-icon>
                            </span>
                        </div>
                    </div>
                    <div class="form-links mt-2 d-flex justify-content-between">
                        <div>
                            <a href="{{ url('/forgot-password') }}" class="text-muted">Forgot Password?</a>
                        </div>
                        <div>
                            <a href="{{ url('/register') }}" class="text-muted">Register</a>
                        </div>
                    </div>


                    <div class="form-button-group">
                        <button type="submit" class="btn btn-orange btn-block btn-lg">Log in</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
    <!-- * App Capsule -->



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>

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

        input[type="password"]::-ms-reveal,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            display: none !important;
            pointer-events: none;
            position: absolute;
            right: -9999px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear input logic
            const clears = document.querySelectorAll('.clear-input');
            clears.forEach(function(clear) {
                clear.addEventListener('click', function() {
                    const input = this.closest('.input-wrapper').querySelector('input');
                    if (input) input.value = '';
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-password');
            toggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('data-target'));
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




</body>

</html>
