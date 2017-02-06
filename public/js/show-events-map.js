
var mapStyleConfig = [{elementType:"geometry",stylers:[{color:"#242f3e"}]},{elementType:"labels.text.fill",stylers:[{color:"#746855"}]},{elementType:"labels.text.stroke",stylers:[{color:"#242f3e"}]},{featureType:"administrative.locality",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#263c3f"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#6b9a76"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#38414e"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{color:"#212a37"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#9ca5b3"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#746855"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#1f2835"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#f3d19c"}]},{featureType:"transit",elementType:"geometry",stylers:[{color:"#2f3948"}]},{featureType:"transit.station",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#17263c"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#515c6d"}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{color:"#17263c"}]}];

function showEventsMap() {
    // Create New Map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 44.4330728,
            lng: 26.1010734
        },
        zoom: 15,
        mapTypeId: 'roadmap'
    });

    // Disable some controls
    map.setOptions({
        streetViewControl: false,
        styles: [],
        mapTypeControl: false
    })

    // Set Style
    var mapStyle = new google.maps.StyledMapType(mapStyleConfig);
    map.mapTypes.set('styled_map', mapStyle);
    map.setMapTypeId('styled_map');

    var blocked = false
    var markers = []

    var markerExists = function(id) {
        var found = false

        markers.forEach(function(marker){
            if (marker.id == id) {
                found = true
            }
        })

        return found
    }

    var resolveEvents = function(data) {
        try {
            var result = JSON.parse(data);

            if (result.events && result.events.length > 0) {
                result.events.forEach(function(event) {
                    if (markerExists(event.id)) {
                        return
                    }

                    var marker = new google.maps.Marker({
                        map: map,
                        title: event.title,
                        position: {
                            lat: parseFloat(event.location_lat),
                            lng: parseFloat(event.location_lng)
                        }
                    });

                    marker.id = event.id

                    var infowindow = new google.maps.InfoWindow({
                        maxWidth: 300,
                        content: '<div class="infoboxMap">\
                            <div class="title">'+event.title+'</div>\
                            <div class="content">'+event.description+'</div>\
                            <div class="attendants">'+event.attendants+' people are coming.</div>\
                            <div class="when">'+event.when+'</div>\
                            <div class="check"><a href="'+event.href+'">Check it out</a></div>\
                        </div>'
                    });

                    marker.addListener('click', function() { infowindow.open(map, marker); })

                    markers.push(marker)
                })
            }
            else {
                console.log('No events found.')
            }
        } catch(e) {
            console.error('Could not read event data.');
        }
    }

    var requestEvents = function(area) {
        if (blocked) {
            return
        }

        blocked = true

        var stringy = area.south + ',' + area.north + ',' + area.west + ',' + area.east
        $.get('/api/events/by-area/' + stringy, function(data, idontcare, request) {
            blocked = false
            resolveEvents(data)
        });
    }

    // Set Events
    map.addListener('bounds_changed', function() {
        var area = map.getBounds().toJSON();

        console.log('Lat between', area.south, area.north)
        console.log('Lng between', area.west, area.east)

        requestEvents(area)
    })
}
