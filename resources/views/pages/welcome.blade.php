@extends('layouts.guest')

@section('content')
    <div class="main-wrapper">
        <div class="main">
            <div class="main-inner">
                <div id="pl-482">
                    <div class="panel-grid" id="pg-482-0">
                        <div style="margin-top: -50px;" class="panel-row-style">
                            <div class="panel-grid-cell" id="pgc-482-0-0">
                                <div class="so-panel widget widget_text panel-first-child" id="panel-482-0-0-0" data-index="0">
                                    <div style="margin-bottom: -30px;" class="panel-widget-style">
                                        <div class="textwidget">
                                            <div class="hero hero-search-wrapper hero-animate">
                                                <div class="hero-search">
                                                    <div class="hero-search-image" style="background-image: url('http://eve-wordpress.wearecodevision.com/wp-content/uploads/2016/08/photo-1471967183320-ee018f6e114a.jpeg');">
                                                    </div>
                                                    <!-- /.hero-search-image -->

                                                    <div class="hero-search-content">
                                                        <h1>Search for the best events in your city</h1>
                                                        <p>Join thousands of meetups, talks, parties and mixers already here!</p>
                                                    </div>
                                                </div>
                                                <!-- /.hero-creative -->
                                            </div>
                                            <!-- /.hero -->
                                        </div>
                                    </div>
                                </div>
                                <div class="so-panel widget widget_text panel-last-child" id="panel-482-0-0-1" data-index="1">
                                    <div class="textwidget">
                                        <div class="cta-small">
                                            <div class="cta-small-inner">
                                                <a href="{{ route('allevents') }}" class="button button-black">Show All Events</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-grid" id="pg-124-2">
                        <div style="background-color: #fafafa;margin: -30px -1200px 0 -1200px;padding: 0 1200px 60px 1200px;" class="panel-row-style">
                            <div class="panel-grid-cell" id="pgc-124-2-0">
                                <div class="so-panel widget widget_text panel-first-child panel-last-child" id="panel-124-2-0-0" data-index="6">
                                    <div class="textwidget">
                                        <div class="page-header">
                                            <h2>Event Categories</h2>
                                            <p>Finding an event is easier. Choose from our various categories. </p>
                                        </div>

                                        <div class="listing-manager-locations-wrapper">
                                            <div class="listing-manager-locations">
                                            @foreach($categories as $category)
                                                <div class="listing-manager-location">
                                                    <div class="listing-manager-location-inner">
                                                        <a href="{{ route('category.show', $category->id) }}" style="background-image: url('/images/categories/{{ $category->image }}');">
                                                            <h3>{{ $category->name }}</h3>
                                                            <h4>{{ $category->events->count() }} events</h4>

                                                            <span class="button">Show Events</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if(!Auth::guest())
                    @include('partials.find_events')
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection