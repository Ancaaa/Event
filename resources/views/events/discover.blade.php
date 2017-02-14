@extends('layouts.application')

@section('content')
    <div class="main-wrapper">
        <div class="main">
            <div class="main-inner">
                @include('partials.find_events', [ 'mapScroll' => true ])
            </div>
        </div>
    </div>
</div>
@endsection