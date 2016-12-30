@extends('main')

@section('title', '|Show Events')

@section('indexscripts')
        <link href="css/style-index.css" rel='stylesheet' type='text/css' />
        <link href="css/style-pagiation.css" rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="images/fav-icon.png" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        </script>
        <!----webfonts---->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <!----//webfonts---->
        <!-- Global CSS for the page and tiles -->
        <link rel="stylesheet" href="css/main.css">
        <script src="js/jquery.min (2).js"></script>
        <!-- //Global CSS for the page and tiles -->
        <!---start-click-drop-down-menu----->
        <script src="js/jquery.min (2).js"></script>
        <!----start-dropdown--->
         <script type="text/javascript">
            var $ = jQuery.noConflict();
                $(function() {
                    $('#activator').click(function(){
                        $('#box').animate({'top':'0px'},500);
                    });
                    $('#boxclose').click(function(){
                    $('#box').animate({'top':'-700px'},500);
                    });
                });
                $(document).ready(function(){
                //Hide (Collapse) the toggle containers on load
                $(".toggle_container").hide(); 
                //Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
                $(".trigger").click(function(){
                    $(this).toggleClass("active").next().slideToggle("slow");
                        return false; //Prevent the browser jump to the link anchor
                });
                                    
            });
        </script>
        <!----//End-dropdown--->
        <!---//End-click-drop-down-menu----->
    </head>
    <body>
        <!---start-wrap---->
            <!---start-header---->
        @endsection 

        @section('content')

<!--        var location = $event->location
        var title =$event->title
        var description = $event->description
        var seached = $global

        var shown = 
          location.split(' ').indexOf(searched) > -1 ||
          title.split(' ').indexOf(searched) > -1 ||
          description.split(' ').indexOf(searched) > -1

        
        if (searched && shown) {


        } -->
        <!---//End-header---->
        <!---start-content---->
        <div class="content">
            <div class="wrap">
             <div id="main" role="main">
                  <ul id="tiles">
                  @foreach($events as $event)
  

                    <!-- These are our grid blocks -->
                    <li onclick="location.href='{{ route('events.show', $event->id) }}';">

                         @if($event->image)
                        <img src="{{asset('images/' . $event->image)}}" width="282" height="118">
                          @else
                          <img src="/images/grey.jpg" width="282" height="118">
                          @endif
                        <div class="post-info">
                            <div class="post-basic-info">
                                <h3><a href="#">{{$event->title}}</a></h3>
                                <span><a href="#"><label> </label>Category: {{$event->category->name}}</a></span>
                                <p>Location: {{$event->location}}
                                <br>Dates: {{date('M j, Y', strtotime($event->startdate)) }} - {{date('M j, Y', strtotime($event->enddate))}}
                                <br>
                                @if(Carbon\Carbon::today()->format('Y-m-d') > $event->enddate )
                                  (Ended)
                                    @endif
                                    </p>
                            </div>
                            <div class="post-info-rate-share">
                              @if( $event->price != 0 )
                                <p>  Price: {{$event->price}}
                                <span> </span></p>
                                @else
                                  <p>  FREE
                                <span> </span></p>
                                @endif
                                
                                <div class="clear"> </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    
                  </ul>
                </div>
                <div class="text-center">
                    <ul class="pagination modal-3">
                       <li> {!! $events->links(); !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!---//End-content---->
        <!----wookmark-scripts---->
          <script src="js/jquery.imagesloaded.js"></script>
          <script src="js/jquery.wookmark.js"></script>
          <script type="text/javascript">
            (function ($){
              var $tiles = $('#tiles'),
                  $handler = $('li', $tiles),
                  $main = $('#main'),
                  $window = $(window),
                  $document = $(document),
                  options = {
                    autoResize: true, // This will auto-update the layout when the browser window is resized.
                    container: $main, // Optional, used for some extra CSS styling
                    offset: 20, // Optional, the distance between grid items
                    itemWidth:280 // Optional, the width of a grid item
                  };
              /**
               * Reinitializes the wookmark handler after all images have loaded
               */
              function applyLayout() {
                $tiles.imagesLoaded(function() {
                  // Destroy the old handler
                  if ($handler.wookmarkInstance) {
                    $handler.wookmarkInstance.clear();
                  }
        
                  // Create a new layout handler.
                  $handler = $('li', $tiles);
                  $handler.wookmark(options);
                });
              }
              /**
               * When scrolled all the way to the bottom, add more tiles
               */
              function onScroll() {
                // Check if we're within 100 pixels of the bottom edge of the broser window.
                var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
                    closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 100);
        
                if (closeToBottom) {
                  // Get the first then items from the grid, clone them, and add them to the bottom of the grid
                  var $items = $('li', $tiles),
                      $firstTen = $items.slice(0, 10);
                //  $tiles.append($firstTen.clone());
        
                  applyLayout();
                }
              };
        
              // Call the layout function for the first time
              applyLayout();
        
              // Capture scroll event.
              $window.bind('scroll.wookmark', onScroll);
            })(jQuery);
          </script>
        <!----//wookmark-scripts---->
        <!----start-footer--->
        <div class="footer">
            <p>Design by <a href="http://w3layouts.com/">W3layouts</a></p>
        </div>
        <!----//End-footer--->
        <!---//End-wrap---->
    </body>
</html>
@endsection

