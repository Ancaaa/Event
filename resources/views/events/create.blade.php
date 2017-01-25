@extends('main')

@section('title', '|Create New Event')

@section('createscripts')
  
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">

   {{-- <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBXEWjOzvyLBozOb4lm7oOrI4eH0YmZOXg&libraries=places&callback=initAutocomplete"
         async defer></script> --}}
   
   <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
   <script src="{{ URL::asset('js/eventform.js') }}"></script>
   <!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
   <script>tinymce.init({  selector:'textarea', 
                           plugins: ["link lists",],                    
                          menubar: false   });</script> -->
    
    
    <link rel="stylesheet" href="{{ URL::asset('css/form-style.css') }}">
    <link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

 <style>
   
   /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        min-height: 200px;
      }
     .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);

      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        color: #000;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
 </style>   

  
</head>

    
<body onload="getRandomColor();">
    
@endsection
    
@section('content')
    <div class="center">
  

<form id="create-form" method="post" action="{{ route('events.store') }}" enctype="multipart/form-data" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
  
        
  <p>
      <input style="font-size:50px;" type="text" name="title" id="title" minlength="3" placeholder="Untitled" required></p>

  <p>
    <div id="locationField">
    <input type="text" name="location" id="pac-input" class="controls" placeholder="Where is it happening?" required>
    </div></p>
    <div id="map"></div>
    
    <p>
    <input type="date" name="startdate" id="startdate" value="Start date" required></p>    
    
    <p>
    <input type="time" name="starttime" id="starttime" value="Start time" required></p> 
        
    <p>
    <input type="date" name="enddate" id="enddate" value="End date" required></p>    
    
    <p>
    <input type="time" name="endtime" id="endtime" value="End time" required></p> 
    
    <p>
    <input type="number" name="price" min="0" id="price" placeholder="Price" required>
    <select name="currency">    
      <option style="color:red;" value="RON">RON</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
      <option value="GBP">GBP</option>
        </select>
    </p>


    <p>
    <label for="category_id">Category</label>
    <select name="category_id"> 
    @foreach($categories as $category)   
      <option style="color:red;" value="{{$category->id}}">{{$category->name}}</option>
     @endforeach
        </select>
    </p>

    <p><input type="file" name="image" id="image"></p>
    
  <p>
    <label for="description">Add a description of the event</label></p>

  <p>
    <textarea name="description" id="description" placeholder="What can you tell us about your event?" class="expanding"></textarea>
  </p>
  <p>
    <button type="submit" >
      <svg version="1.1" class="send-icn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100px" height="36px" viewBox="0 0 100 36" enable-background="new 0 0 100 36" xml:space="preserve">
        <path d="M100,0L100,0 M23.8,7.1L100,0L40.9,36l-4.7-7.5L22,34.8l-4-11L0,30.5L16.4,8.7l5.4,15L23,7L23.8,7.1z M16.8,20.4l-1.5-4.3
	l-5.1,6.7L16.8,20.4z M34.4,25.4l-8.1-13.1L25,29.6L34.4,25.4z M35.2,13.2l8.1,13.1L70,9.9L35.2,13.2z" />
      </svg>    
      <small>send</small>
    </button>
  </p>
        
       <!-- <input type="hidden" name="_token" value="{{ Session::token() }}"> -->
</form>
    </div>

    <script>

     function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
 
@endsection
