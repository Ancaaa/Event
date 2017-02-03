<li class="product summ">
    <a href="{{ url('/events', $event->id) }}" class="woocommerce-LoopProduct-link">
        <div class="product-image-wrapper">
            @if($event->image)
            <img width="400" height="340" src="{{ '/images/events/' . $event->image }}" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">
            @else
            <img width="400" height="340" src="{{ '/images/thumbs/01.jpg' }}" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">
            @endif
        </div>

        <div class="product-date">
            <span class="day">{{ date('d', strtotime($event->startdate))}}</span><span class="month">{{ date('M', strtotime($event->startdate)) }}</span><span class="year">{{ date('Y', strtotime($event->startdate)) }}</span>
            <span class="day">{{ date('H', strtotime($event->starttime)) }}</span><span class="year">{{ date('i', strtotime($event->starttime)) }}</span>
        </div>

        <h3>{{ $event->title }}</h3>

        <div class="product-location loc">
            <i class="lnr lnr-map-marker"></i>
            {{ $event->location }}
        </div>

        <div class="product-location loc">
            <i class="lnr lnr-hourglass"></i>
            {{ $event->durationNow() }}
        </div>

        <span class="onsale">{{ $event->duration() }}</span>
        <span class="price">
            <span class="woocommerce-Price-amount amount">
                @if($event->price == 0)
                    Free
                @else
                    {{ $event->price }} {{ $event->currency }}
                @endif
            </span>
        </span>
    </a>
</li>