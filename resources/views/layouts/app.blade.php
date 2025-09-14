<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (!empty($data['title']))
            {{ $data['title'] }}
        @endif
        {{ !empty($data['header_title']) ? $data['header_title'] : '' }}
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favi.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/favi.png') }}">

    {{-- custom css --}}
    <link href="{{ asset('admin/assets/css/main-auth.css') }}" rel="stylesheet">

</head>

<body>

    <div class="container-fluid login-page d-flex justify-content-center align-items-center vh-100 p-3">
        <div class="login-card row shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeIn">
            <div
                class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-0 position-relative slider-container">
                <div class="p-4 d-flex justify-content-between align-items-center position-absolute w-100"
                    style="z-index: 10;">
                    <div class="logo">
                        <span class="text-white fs-4 fw-bold">AMD</span>
                    </div>
                </div>

                <div class="slide-content-wrapper flex-grow-1 d-flex flex-column justify-content-end pb-4 px-5 text-white position-absolute w-100 h-100"
                    style="z-index: 5;">
                    <h1 class="display-5 fw-bold mb-3 slogan-text">Your Memories, <br> Just a Click Away</h1>
                    <div class="d-flex justify-content-center gap-2 mt-4 slider-dots">
                        <span class="dot active" data-slide-index="0"></span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="slide active"
                        style="background-image: url('{{ asset('admin/assets/img/auth.avif') }}');">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 right-section p-4 p-md-5">
                @yield('content')

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom Js --}}
    <script src="{{ asset('admin/assets/js/auth-main.js') }}"></script>

</body>

</html>
