@extends('layouts.admin')
@section('content')
    <div class="main-wrapper admin-page">
        <div class="main">
            <div class="main-inner padd">
                <div class="page-title">
                    @php
                        function tryNaming() {
                            $exploded = explode("/", url()->full());
                            if (sizeof($exploded) > 4) {
                                return ucfirst($exploded[3]) . ' ' . ucfirst($exploded[4]);
                            }
                            else {
                                return ucfirst($exploded[3]);
                            }
                        }
                    @endphp
                    <div class="page-title-inner"><h1>{{ isset($pageTitle) ? $pageTitle : tryNaming() }}</h1></div>
                </div>
                @yield('content_full')
            </div>
        </div>
    </div>
@endsection
