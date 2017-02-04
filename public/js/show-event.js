var mapStyleConfig = [{elementType:"geometry",stylers:[{color:"#242f3e"}]},{elementType:"labels.text.fill",stylers:[{color:"#746855"}]},{elementType:"labels.text.stroke",stylers:[{color:"#242f3e"}]},{featureType:"administrative.locality",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#263c3f"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#6b9a76"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#38414e"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{color:"#212a37"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#9ca5b3"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#746855"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#1f2835"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#f3d19c"}]},{featureType:"transit",elementType:"geometry",stylers:[{color:"#2f3948"}]},{featureType:"transit.station",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#17263c"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#515c6d"}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{color:"#17263c"}]}];

function showEventMap() {

  // Get Event Location
  var title = document.getElementById('locationData').textContent;
  var locationLat = document.getElementById('latData').textContent;
  var locationLng = document.getElementById('lngData').textContent;

  // Create New Map
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {
      lat: parseFloat(locationLat),
      lng: parseFloat(locationLng)
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

  marker = new google.maps.Marker({
      map: map,
      title: title,
      position: {
        lat: parseFloat(locationLat),
        lng: parseFloat(locationLng)
      }
    });
}

function tryAgain() {
    setTimeout(function() {
        showEventMap();
    }, 150)
}
