@extends('layouts.application')
@section('content')
    <div class="main-wrapper">
        <div class="main">
            <div class="main-inner padd">
                @if(isset($hero) && $hero === 'event-detail')
                    <div class="page-title">
                        <div class="page-title-inner">
                            <strong>{{ $event->category->name }}</strong>
                            <h1>{{ $event->title }}</h1>

                            <div class="page-title-meta">
                                <div class="page-title-meta-item">
                                    <strong>Price</strong>
                                    <span>{{ $event->price }} {{ $event->currency }}</span>
                                </div>

                                <div class="page-title-meta-item">
                                    <strong>Address</strong>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="woocommerce-breadcrumb">
                        <a href="{{ url('/allevents') }}">Events</a>
                        <span class="separator">/</span> <a href="#">{{ $event->category->name }}</a>
                        <span class="separator">/</span> {{ $event->title }}
                    </nav>
                @else
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
                    {{-- <nav class="woocommerce-breadcrumb">
                        <a href="{{ url('/') }}">Home</a>
                    </nav> --}}
                @endif
                @yield('content_full')
            </div>
        </div>
    </div>
@endsection
