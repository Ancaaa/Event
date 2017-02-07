@extends('layouts.application_full')

@section('extra-headers')
    <script>$(document).ready(function() { $('body').addClass('has-sidebar') })</script>
    <script src="{{ URL::asset('js/create_event_summary.js') }}"></script>
    <script src="{{ URL::asset('js/search-events.js') }}"></script>
@endsection

@section('content_full')
    <div class="content">
        <div id="container">
            <div id="content" role="main">
                <p class="woocommerce-result-count">Showing all <span id="numResults">0</span> results</p>

                <form class="woocommerce-ordering" method="GET">
                    <select id="sortBy" name="orderby" class="orderby">
                        <option value="menu_order" selected="selected">Default sorting</option>
                        <option value="popularity">Sort by popularity</option>
                        <option value="date">Sort by newness</option>
                        <option value="price">Sort by price: low to high</option>
                        <option value="price-desc">Sort by price: high to low</option>
                        <option value="event_date">Sort by event date</option>
                    </select>
                </form>

                <ul class="products"></ul>
            </div>
        </div>
    </div>

    <div class="sidebar">
        <div id="filter-3" class="widget widget_filter">
            <div class="widget-inner">
                <h2 class="widgettitle">Filter Events</h2>
                <form onsubmit="return false;" class="listing-manager-filter-form placeholders">
                    <div class="listing-manager-filter-form-inner">
                        <div class="form-group form-group-keyword">
                            <input id="filter-keyword" type="text" name="filter-keyword" placeholder="Keyword" class="form-control">
                        </div>

                        <div class="form-group form-group-price form-group-price-from">
                            <input id="filter-price-from" type="text" name="filter-price-from" placeholder="Price from" class="form-control">
                        </div>

                        <div class="form-group form-group-price form-group-price-to">
                            <input id="filter-price-to" type="text" name="filter-price-to" placeholder="Price to" class="form-control">
                        </div>

                        <div class="form-group">
                            <select id="filter-listing-categories" class="form-control chained" name="filter-listing-categories">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" class="0">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group form-group-event-date-from">
                            <label>From Date</label>
                            <input type="date" id="filter-event-date-from" name="filter-event-date-from" placeholder="Event date from" class="form-control listing-manager-date-input">
                        </div>

                        <div class="form-group form-group-event-date-to">
                            <label>To Date</label>
                            <input type="date" id="filter-event-date-to" name="filter-event-date-to" placeholder="Event date to" class="form-control listing-manager-date-input">
                        </div>

                        {{-- <div class="form-group form-group-button">
                            <button id="search-button" class="button" type="submit">Search Events</button>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection