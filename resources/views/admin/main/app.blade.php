<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (!empty($data['title']))
            {{ $data['title'] }}
        @endif
        {{ !empty($data['header_title']) ? $data['header_title'] : '' }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favi.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/favi.png') }}">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    {{-- Custom Ui Components --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
    {{-- Main(Custom Css) --}}
    <link href="{{ asset('admin/assets/css/main.css') }}" rel="stylesheet" />
    {{-- Custom(from my side) --}}
    <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet" />
    <!-- Summernote -->
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css') }}"
        rel="stylesheet">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Flatpickr for date1 picker --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/flatpicker_material_blue.css') }}">
    {{-- Custom styles for used inline css --}}

        <!-- nepali date picker -->
    <link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.5.min.css"
        rel="stylesheet" />

    {{-- Ranjit Editor --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ranjitraut-sta/ranjit-editor@main/assets/main.css?v=2.1">

    @yield('styles')
</head>

<body>
    @include('admin.main.sidebar') {{-- Sidebar include --}}
    <div id="amdSidebarOverlay" class="amd-sidebar-overlay"></div>
    <div class="amd-main-content">
        @include('admin.main.header') {{-- Header include --}}
        @include('alert.amd-toast') {{-- Alert include --}}
        <div class="amd-dashboard-content-area">
            <div class="row p-4">
                <div class="col-12">
                    @yield('content') {{-- content extend --}}
                </div>
            </div>
        </div>
        @include('admin.main.footer') {{-- Footer include --}}
        @stack('scripts') {{-- scripts extend --}}
</body>

</html>
