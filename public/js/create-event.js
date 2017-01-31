var mapStyleConfig = [{elementType:"geometry",stylers:[{color:"#242f3e"}]},{elementType:"labels.text.fill",stylers:[{color:"#746855"}]},{elementType:"labels.text.stroke",stylers:[{color:"#242f3e"}]},{featureType:"administrative.locality",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#263c3f"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#6b9a76"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#38414e"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{color:"#212a37"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#9ca5b3"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#746855"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#1f2835"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#f3d19c"}]},{featureType:"transit",elementType:"geometry",stylers:[{color:"#2f3948"}]},{featureType:"transit.station",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#17263c"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#515c6d"}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{color:"#17263c"}]}];

function initCreateEventMap() {

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

  // Deps
  var input = document.getElementById('pac-input');
  var locationLat = document.getElementById('location_lat')
  var locationLng = document.getElementById('location_lng')
  var searchBox = new google.maps.places.SearchBox(input);
  var marker = null;
  var geocoder = new google.maps.Geocoder;
  // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Custom Logic
  var setLocation = function(location, skip, cb) {
    geocoder.geocode({
      'location': location
    }, function(results, status) {
      if (status === 'OK' && results && results.length > 0) {
        input.value = results[0].formatted_address;
        locationLat.value = location.toJSON().lat;
        locationLng.value = location.toJSON().lng;

        if (!skip) {
          if (marker) {
            marker.setMap(null);
          }

          marker = new google.maps.Marker({
            position: location,
            map: map
          });
        }

        cb()
      }
    });
  }

  // Results relevancy by the map's bounds
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  // Set Location on Map Click
  map.addListener('click', function(e) {
    setLocation(e.latLng)
  })

  // Set Location on Place Search
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    var place = places[0]
    var bounds = new google.maps.LatLngBounds();

    if (!place.geometry) {
      console.log("Returned place contains no geometry");
      return;
    }

    if (marker) {
      marker.setMap(null);
    }

    setLocation(place.geometry.location, true, function() {
        input.value = place.name;
    })

    marker = new google.maps.Marker({
      map: map,
      title: place.name,
      position: place.geometry.location
    });

    if (place.geometry.viewport) {
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
}
