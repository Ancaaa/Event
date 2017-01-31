<!DOCTYPE HTML>
<html>
<head>
    @include('partials.head')
    @yield('extra-headers')
</head>
<body class="page-template page-template-page-front-page page-template-page-front-page-php page page-id-482 siteorigin-panels has-sidebar woocommerce header-size-fixed sticky-header-type-white header-type-minimal-transparent loaded hero-welcome-page">
    <div class="page-wrapper">
        @include('partials.header', ['experience' => 'hero'])
        @yield('content')
        @include('partials.footer')
    </div>
</body>
</html>