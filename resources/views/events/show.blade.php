@extends('layouts.application_full')

@section('extra-headers')
    <script src="{{ URL::asset('js/show-event.js') }}"></script>
    <style>
        #map {
            height: 500px;
        }
    </style>
    <script>
        EventUApp.eventId = {{ $event->id }}
    </script>
@endsection

@section('content_full')

<div class="content">
    <div id="container">
        <div id="content" role="main">
            <!-- Start Event -->
            <div class="product">

                <div class="summ">
                    <div class="event-details">
                        <div class="event-details-inner">
                            <div class="event-details-header">
                                <div class="event-details-date">
                                    <i class="lnr lnr-calendar-full"></i>
                                    Event starts on {{ $event->startdate }} {{ $event->starttime }}
                                </div>

                                <div class="event-details-actions">
                                    @if(Auth::check())
                                        <a id="action-going" class="button button-secondary">#nostatus</a>
                                        @if($event->creator_id === Auth::id())
                                            <a href="{{ url('/events/' . $event->id . '/edit') }}" class="button button-secondary">Edit</a>
                                        @endif
                                        @if (Auth::check() && Auth::user()->isAdmin() || $event->creator_id === Auth::id())
                                            <form method="POST" action="{{ route('events.destroy', $event->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="button button-secondary">Delete</button>
                                            </form>
                                        @endif
                                        @if (Auth::check() && Auth::user()->isAdmin())
                                            <a class="button button-black warnButton">Warn</a>
                                        @endif
                                    @else
                                        <a class="testButtonGrey" href="{{ url('/login') }}">Please login to join</a>
                                    @endif
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        var yougoing = $('#action-going')

                                        if (!yougoing[0]) {
                                            return
                                        }

                                        var toggle = function(attending) {
                                            yougoing.text(attending ? "Leave" : 'Join')
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
                            </div>

                            <ul class="attributes">
                                <li>
                                    <strong>Ends</strong>
                                    <span>{{ $event->enddate }} {{ $event->endtime }}</span>
                                </li>

                                <li>
                                    <strong>Location</strong>
                                    <span id="locationData">{{ $event->location }}</span>
                                </li>

                                <li>
                                    <strong>Category</strong>
                                    <span>{{ $event->category->name }}</span>
                                </li>

                                <li>
                                    <strong>Created on</strong>
                                    <span>{{ $event->created_at }}</span>
                                </li>

                                <li>
                                    <strong>Author</strong>
                                    <span><a href="{{ route('profile.show', $event->creator->id) }}">{{ $event->creator->name }}</a></span>
                                </li>

                                <li>
                                    <strong>Number of people attending</strong>
                                    <span>{{ $event->users->count() }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="woocommerce-tabs wc-tabs-wrapper">
                    <ul class="tabs wc-tabs">
                        <li class="description_tab active">
                            <a href="#tab-description">Description</a>
                        </li>
                        {{-- <li class="social_tab">
                            <a href="#tab-social">Social</a>
                        </li> --}}
                        <li class="location_tab" onclick="tryAgain()">
                            <a href="#tab-location">Location</a>
                        </li>
                        <li class="going_tab">
                            <a href="#tab-going">Who's Going?</a>
                        </li>
                    </ul>

                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" style="display: block;">
                        <h2>Description</h2>

                        <div class="description-panel">
                            {{ $event->description }}
                        </div>
                    </div>

                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--social panel entry-content wc-tab" id="tab-social" style="display: none;">
                        <h2>Social Networks</h2>

                        <div class="listing-manager-social-networks">
                            <div class="listing-manager-social-network">
                                <a class="facebook" target="_blank" href="#">Facebook</a>
                            </div>
                            <div class="listing-manager-social-network">
                                <a class="twitter" target="_blank" href="#">Twitter</a>
                            </div>
                            <div class="listing-manager-social-network">
                                <a class="linkedin" target="_blank" href="#">Linkedin</a>
                            </div>
                        </div>
                    </div>

                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--amenities panel entry-content wc-tab" id="tab-amenities" style="display: none;">
                        <h2>Amenities</h2>

                        <ul class="amenities">
                            <li>Balcony</li>
                            <li>Cofee pot</li>
                            <li>Dishwasher</li>
                            <li>Fan</li>
                            <li>Grill</li>
                            <li>Pool</li>
                            <li>Radio</li>
                            <li>Terrace</li>
                            <li>Use of pool</li>
                        </ul>
                    </div>

                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--location panel entry-content wc-tab" id="tab-location" style="display: none;">
                        <h2>Location</h2>

                        <span class="hidden" id="latData">{{ $event->location_lat }}</span>
                        <span class="hidden" id="lngData">{{ $event->location_lng }}</span>

                        <div style="padding-bottom: 20px;">
                            <dl>
                                <dt>Location Name</dt>
                                <dd>{{ $event->location }}</dd>
                            </dl>
                            <a class="button button-black"
                                target="_blank"
                                href="https://maps.google.com?daddr={{ $event->location_lat }},{{ $event->location_lng }}">
                                Get directions
                            </a>
                        </div>

                        <div id="map"></div>

                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5eNDyxYWDkm8_2n-bJ39vaJDFFr4Hrw&libraries=places&callback=showEventMap&language=ro&region=RO" async defer></script>

                        {{-- <div style="height:500px;width:100%;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                            <div id="display-google-map" style="height:100%; width:100%;max-width:100%;">
                                <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=37.400198,-122.131055&amp;key=AIzaSyDmXybAJzoPZ6hH-Jhv7QMCSGgQ6MY8WqY">
                                </iframe>
                            </div>

                            <style>#display-google-map img{max-width:none!important;background:none!important;font-size: inherit;}</style>
                        </div> --}}
                    </div>

                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--contact panel entry-content wc-tab" id="tab-going" style="display: none;">
                        <h2>Who's Going?</h2>
                        <div class="event-attendants">
                            {{-- TODO: Design --}}
                            @foreach ($event->users as $attendant)
                                <div class="attendant">
                                    <div class="picture" style="background-image:url(/images/avatars/{{ $attendant->profile->profilepic }})"></div>
                                    <a href="{{ route('profile.show', $attendant->id) }}">{{ $attendant->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- <div class="inquire-form-wrapper">
                    <h2>Contact Listing Owner</h2>

                    <form method="post" action="http://eve-wordpress.wearecodevision.com/product/guitar-course/" class="inquire-form">
                        <div class="inquire-form-login-required">
                            <p>
                                <a href="{{ url('/login') }}">Please login before posting inquire</a>
                            </p>
                        </div>

                        <input type="hidden" name="post_id" value="{{ $event->id }}">

                        <div class="inquire-form-fields">
                            <div class="form-group form-group-name">
                                <input class="form-control" name="name" type="text" placeholder="Name" required="required">
                            </div>

                            <div class="form-group form-group-email">
                                <input class="form-control" name="email" type="email" placeholder="E-mail" required="required">
                            </div>

                            <div class="form-group form-group-subject">
                                <input class="form-control" name="subject" type="text" placeholder="Subject" required="required">
                            </div>
                        </div>

                        <div class="form-group form-group-message">
                            <textarea class="form-control" name="message" required="required" placeholder="Message" rows="4"></textarea>
                        </div>

                        <div class="button-wrapper">
                            <button type="submit" class="button" name="inquire_form">Send Message</button>
                        </div>
                    </form>
                </div> --}}

                <div class="comments-section">
                    <div class="event-details">
                        <div class="event-details-inner">
                            <div class="event-details-header">
                                <div class="event-details-date">
                                    <i class="lnr lnr-bubble"></i>
                                    Comments
                                </div>
                            </div>
                            <div class="event-details-inner">
                                @foreach ($event->comments as $comment)
                                    <div class="comment">
                                        <div class="avatar_holder">
                                            <div class="avatar" style="background-image: url('/images/avatars/{{ $comment->user->profile->profilepic }}');"></div>
                                        </div>
                                        <div class="content">
                                            <div class="identifier">
                                                <a href="{{ url('/profiles/' . $comment->user->id) }}">{{ $comment->username }}</a>
                                            </div>
                                            <div class="comment-text">
                                                {{ $comment->comment }}
                                            </div>
                                            <div class="comment-meta">
                                                <span>{{ $comment->created_at }}</span>
                                                @if (Auth::check() && Auth::user()->isAdmin() || $comment->user->id === Auth::id())
                                                    <a href="{{ route('comments.delete', $comment->id) }}" class="deleteButton">Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if(Auth::check())
                                <div class="artical-commentbox" id="comment">
                                    <h2>Leave a Comment</h2>

                                    <div class="table-form">
                                        <form method="post" action="{{ route('comments.store', $event->id) }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <div>
                                                <label>Your Comment</label>
                                                <textarea name="comment"> </textarea>
                                            </div>
                                            <br />
                                            <input type="submit" value="Add Comment">
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="related products">
                    <h2>Related Items</h2>

                    <ul class="products">
                        <!-- Like all events -->
                    </ul>
                </div> --}}

                {{-- <div class="next-prev-links">
                    <div class="prev">
                        <a href="http://eve-wordpress.wearecodevision.com/product/food-festival/" rel="prev">
                            <i class="fa fa-chevron-left"></i>
                            Food Festival
                        </a>
                    </div>

                    <div class="next">
                        <a href="http://eve-wordpress.wearecodevision.com/product/memorable-cruise-around-the-world/" rel="next">
                            Memorable Cruise Around The World
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
            <!-- End End -->
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            var warnButton = $('.warnButton')
            warnButton.click(function() {
                $.get('{{ route('events.warn', $event->id) }}', function(data, idontcare, request) {});
            });
        });
    </script>
@endsection