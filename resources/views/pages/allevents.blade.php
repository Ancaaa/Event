@extends('layouts.application')

@section('content')
    <div class="main-wrapper">
        <div class="main">
            <div class="main-inner">
                <div class="panel-grid">
                    <div style="background-color: #fafafa; margin: 0 -1200px -30px -1200px; padding: 0 1200px 50px 1200px;" class="panel-row-style">
                        <div class="panel-grid-cell">
                            <div class="so-panel widget widget_text panel-first-child panel-last-child">
                                <div class="page-header">
                                    <h2>Popular Events</h2>
                                    <p>Find the best events suited for you needs?!?!.</p>
                                </div>

                                <div class="woocommerce columns-5">
                                    <ul class="products">
                                        @foreach ($events as $event)
                                            @include('partials.event_summary', ['event' => $event])
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('partials.find_events')

            </div>
        </div>
    </div>
</div>
@endsection