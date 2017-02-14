@extends('layouts.application_full')

@section('content_full')
    <div class="panel-grid">
        <div class="panel-row-style">
            <div class="panel-grid-cell">
                <div class="so-panel widget widget_text panel-first-child panel-last-child">

                    <div class="listing-manager-locations-wrapper">
                        <div class="listing-manager-locations">
                            @foreach ($categories as $category)
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
@endsection