@extends('main')

@section('title', '|Edit Event')

@section('createscripts')
  
   <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
   <script src="{{ URL::asset('js/eventform.js') }}"></script>
  <!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
   <script>tinymce.init({  selector:'textarea', 
                           plugins: ["link lists",],                    
                          menubar: false   });</script> -->
    
    
    <link rel="stylesheet" href="{{ URL::asset('css/form-style.css') }}">
    <link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    

  
</head>

    
<body onload="getRandomColor();">
    
@endsection
    
@section('content')
    <div class="center">
  

<form id="create-form" method="post" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data"  >
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
  
        
  <p>
      <input style="font-size:50px; type="text" name="title" id="title" minlength="3" value="{{ $event->title }}" required></p>

  <p>
    <input type="text" name="location" id="location" value="{{ $event->location}}" required>
  </p>
    
    <p>
    <input type="date" name="startdate" id="startdate" placeholder="When does it start?" value= "{{ $event->startdate}}" required ></p>    
    
    <p>
    <input type="time" name="starttime" id="starttime" placeholder="When does it start?" value= "{{ $event->starttime}}" required></p> 
        
    <p>
    <input type="date" name="enddate" id="enddate" placeholder="When does it start?" value= "{{ $event->enddate}}" required></p>    
    
    <p>
    <input type="time" name="endtime" id="endtime" placeholder="When does it start?" value= "{{ $event->endtime}}" required></p> 
    
    <p>
    <input type="number" name="price" min="0" id="price" value= "{{ $event->price}}" required>
    <select name="currency">    
      <option value="RON" {{ $event->currency === "RON" ? 'selected' : '' }}>RON</option>
      <option value="USD" {{ $event->currency === "USD" ? 'selected' : '' }}>USD</option>
      <option value="EUR" {{ $event->currency === "EUR" ? 'selected' : '' }}>EUR</option>
      <option value="GBP" {{ $event->currency === "GBP" ? 'selected' : '' }}>GBP</option>
        </select>
    </p>

    <p>
    <label for="category_id">Category</label>
    <select name="category_id" > 
    @foreach($categories as $category)   
      <option style="color:red;" value="{{$category->id}}" {{ $event->category_id === $category->id ? 'selected' : '' }}>{{$category->name}}</option>
     @endforeach
        </select>
    </p>

    <p><input type="file" name="image" id="image"></p>
    <p><img src="{{ $event->image }}" /></p>
  <p>
    <label for="description">Add a description of the event</label></p>

  <p>
    <textarea name="description" id="description" placeholder="What can you tell us about your event?" class="expanding">{{ $event->description }}</textarea>
  </p>
  <p>
    <button type="submit" >
      <svg version="1.1" class="send-icn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100px" height="36px" viewBox="0 0 100 36" enable-background="new 0 0 100 36" xml:space="preserve">
        <path d="M100,0L100,0 M23.8,7.1L100,0L40.9,36l-4.7-7.5L22,34.8l-4-11L0,30.5L16.4,8.7l5.4,15L23,7L23.8,7.1z M16.8,20.4l-1.5-4.3
	l-5.1,6.7L16.8,20.4z M34.4,25.4l-8.1-13.1L25,29.6L34.4,25.4z M35.2,13.2l8.1,13.1L70,9.9L35.2,13.2z" />
      </svg>    
      <small>Save</small>
    </button>
  </p>
         {{ method_field('PUT') }}
       
</form>
    </div>
 
</body>
</html>
@endsection
