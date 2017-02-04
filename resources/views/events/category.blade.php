@extends('layouts.application_full')

@section('content_full')
    <div class="panel-grid">
        <div class="panel-row-style">
            <div class="panel-grid-cell">
                <div class="so-panel widget widget_text panel-first-child panel-last-child">

                    <div class="woocommerce columns-5">
                        <ul class="products">
                            @foreach ($category->events as $event)
                                @include('partials.event_summary', ['event' => $event])
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection