<!DOCTYPE HTML>
<html>
<head>
    @include('partials.head')
    @yield('extra-headers')
</head>
<body class="page-template page-template-page-no-sidebar page-template-page-no-sidebar-php page page-id-9 woocommerce sticky-header-type-white header-type-white loaded">
    <div class="page-wrapper">
        @include('partials.header', ['experience' => 'full'])
        @yield('content')
        @include('partials.footer')
        @yield('extra-scripts')

        @if (Auth::check())
            <script src="{{ URL::asset('js/list-notifications.js') }}"></script>
        @endif
    </div>
</body>
</html>