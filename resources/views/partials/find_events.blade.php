<script>var mapScroll = {{ isset($mapScroll) && $mapScroll ? 'true' : 'false' }}</script>
<script src="{{ URL::asset('js/show-events-map.js') }}"></script>

<div class="panel-grid">
    <div style="background-color: #fafafa; margin: 0 -1200px -30px -1200px; padding: 0 1200px 50px 1200px;" class="panel-row-style">
        <div class="panel-grid-cell">
            <div class="so-panel widget widget_text panel-first-child panel-last-child">
                <div class="page-header">
                    <h2>Discover Events</h2>
                    <p>Browse the map to find events in your area.</p>
                </div>

                <div id="map"></div>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5eNDyxYWDkm8_2n-bJ39vaJDFFr4Hrw&libraries=places&callback=showEventsMap&language=ro&region=RO" async defer></script>
            </div>
        </div>
    </div>
</div>