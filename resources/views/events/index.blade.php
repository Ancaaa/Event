@extends('layouts.application_full')

@section('content_full')
<div class="panel-grid">
    <div class="panel-row-style">
        <div class="panel-grid-cell">
            <div class="so-panel widget widget_text panel-first-child panel-last-child">

                <div class="woocommerce columns-5">
                    <ul class="products">
                        @foreach ($events as $event)
                            <li class="product">
                                <a href="{{ url('/events', $event->id) }}" class="woocommerce-LoopProduct-link">
                                    <div class="product-image-wrapper">
                                        <img width="400" height="340" src="{{ '/images/' . $event->image }}" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">
                                    </div>

                                    <div class="product-date">
                                        <span class="day">{{ date('d', strtotime($event->startdate))}}</span><span class="month">{{ date('M', strtotime($event->startdate)) }}</span><span class="year">{{ date('Y', strtotime($event->startdate)) }}</span>
                                    </div>

                                    <h3>{{ $event->title }}</h3>

                                    <div class="product-location">
                                        {{ $event->location }}
                                    </div>

                                    <span class="onsale">0 minutes</span>
                                    <span class="price">
                                        <span class="woocommerce-Price-amount amount">{{ $event->price}} {{ $event->currency }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection