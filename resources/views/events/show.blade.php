@extends('main')

@section('title', '|View Event')

@section('showscripts')
<link rel="stylesheet" href="{{ URL::asset('css/style-welcome-buttons.css') }}">
        <link href="{{ URL::asset('css/style-index.css') }}" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="images/fav-icon.png" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        </script>
        <!----webfonts---->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <script src="{{URL::asset('js/jquery.min (2).js') }}"></script>


</head>

<body>

@endsection
    
@section('content')

<div class="content">
            <div class="wrap">
            <div class="single-page">
                            <div class="single-page-artical">
                                <div class="artical-content">
                                    @if($event->image)
                                    <img src="{{asset('images/' . $event->image)}}" title="banner1">
                                    @endif
                                    <h3>{{$event->title}}</h3>
                                    <small><b>Category:</b>{{$event->category->name}}</small>
                                    <p><b>Location: </b> {{$event->location}}</p> 
                                    <p class="para1"><b>Date: </b> {{date('M j, Y',strtotime($event->startdate)) }} {{$event->starttime}} - {{date('M j, Y',strtotime($event->enddate)) }} {{$event->endtime}}</p> 
                                    <p><b>Price:</b>{{$event->price}} {{$event->currency}}</p>
                                    <p class="para2">{{$event->description}}</p> 

                                    @if (Auth::user()->id != $event->creator_id)
                                        <button id="yougoing" class="action-button shadow animate"></button>
                                     @endif 
                                    
                                    </div>
                                    

                                    @if(Auth::user()->id == $event->creator_id)
                                    <div class="artical-links">
                                    <ul>
                                        <li><a href="//localhost:8000/events/{{$event->id}}/edit"><button><img src="/images/editbutton.png" ><span>Edit</span></button></a></li>

                                        <li><div class="col-sm-6">
                        <form method="POST" action="{{route('events.destroy', $event->id)}}">
                                <button type="submit"><img src="/images/deletebutton.png"><span>Delete</span></button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            {{ method_field('DELETE') }}
                        </form>
                                        </div></li>
                                    </ul>
                                 </div>
                                 @endif
                                    
                                 <div class="clear"> </div>
                            </div>
                            <!--start-comments-section-->
                <div class="comment-section">
                <div class="grids_of_2">
                    <h2>Comments</h2>

                    @foreach ($event->comments as $comment)
                    <div class="grid1_of_2">
                        <div class="grid_img">
                            <a href=""><img src="/images/pic10.jpg" alt=""></a>
                        </div>
                        <div class="grid_text">
                            <h4 class="style1 list"><a href="#">{{$comment->username}}</a></h4>
                            <h3 class="style">{{$comment->created_at}}</h3>
                            <p class="para top"> {{$comment->comment}}</p>
                            <a href="#comment" class="btn1">Click to Reply</a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    @endforeach
                    <!--<div class="grid1_of_2 left" id="reply">
                        <div class="grid_img">
                            <a href=""><img src="/images/pic10.jpg" alt=""></a>
                        </div>
                        <div class="grid_text">
                            <h4 class="style1 list"><a href="#">Designer First</a></h4>
                            <h3 class="style">march 3, 2013 - 4.00 PM</h3>
                            <p class="para top"> All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
                            <a href="" class="btn1">Click to Reply</a>
                        </div>
                        <div class="clear"></div> 
                    </div>    -->
                              @if(Auth::check())               
                        <div class="artical-commentbox" id="comment">
                            <h2>Leave a Comment</h2>
                            <div class="table-form">
                                <form method="post" action="{{ route('comments.store', $event->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                    <div>
                                        <label>Your Comment</label>
                                        <textarea name="comment"> </textarea>  
                                    </div>
                                <input type="submit" value="submit">
                                </form>
                                    
                            </div>
                            @endif
                            <div class="clear"> </div>
                            
                        </div>          
                    </div>
            </div>
                            <!---//End-comments-section--->
                        </div>
                         </div>
        </div>

        <!----start-footer--->
        <div class="footer">
            <p>Design by <a href="http://w3layouts.com/">W3layouts</a></p>
        </div>
        <!----//End-footer--->
        <!---//End-wrap---->

        <script>
            $(document).ready(function() {
                var yougoing = $('#yougoing')

                var toggle = function(attending) {
                    yougoing.text(attending ? 'Not Going' : 'Going')
                    yougoing.addClass(attending ? 'red' : 'yellow')
                    yougoing.removeClass(attending ? 'yellow' : 'red')
                }

                $.get('/events/{{ $event->id }}/status/', function(data) {
                    var result = JSON.parse(data);
                    toggle(result.attending)
                })

                yougoing.click(function() {
                    $.get('/events/{{ $event->id }}/toggle', function(data) {
                        var result = JSON.parse(data);
                        toggle(result.attending)
                    })
                });
            });
        </script>
@endsection
