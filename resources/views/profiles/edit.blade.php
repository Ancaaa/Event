@extends('main')

@section('title', '|Update profile')

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
  

<form id="create-form" method="post" action="{{ route('profiles.update', $profile->user_id) }}" enctype="multipart/form-data" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
  
         <label for="firstname">Firstname</label></p>
  <p>
      <input type="text" name="firstname" id="firstname" minlength="3" value="{{ $profile->firstname }}"></p>

       <label for="lastname">Lastname</label></p>
  <p>
    <input type="text" name="lastname" id="lastname" value="{{ $profile->lastname }}"></p>
    
       <label for="location">Current city</label></p>
  <p>
    <input type="text" name="location" id="location" value="{{ $profile->location }}"></p>

     <label for="birthdate">Birthday</label></p>
   <p>
    <input type="date" name="birthdate" id="birthdate" value="{{ $profile->birthdate }}"></p>
    
     <label for="gender">Gender</label></p>
    <p>
    <input type="text" name="gender" id="gender" value="{{ $profile->gender }}"></p>

     <label for="profilepic">Choose a profile pic</label></p>
    <p><input type="file" name="profilepic" id="profilepic"></p>
    
  <p>
    <label for="bio">Add a description of you</label></p>

  <p>
    <textarea name="bio" id="bio" placeholder="What can you tell us about your eventyou?" class="expanding"> {{ $profile->bio }} </textarea>
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
         {{ method_field('PUT') }}
       
       <!-- <input type="hidden" name="_token" value="{{ Session::token() }}"> -->
</form>
    </div>
 
@endsection
