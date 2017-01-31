@extends('layouts.application_full')

@section('content_full')

<div class="content">
    <div id="container">
        <div id="content" role="main">
            <!-- Start Profile Page -->

            <div class="profile-summary">
                <div class="header">
                    <div class="profile-avatar" style="background-image: url('/images/{{ $profile->profilepic }}'); margin: auto; margin-bottom: 50px;"></div>

                    <div class="post-social profile">
                        <ul>
                            <li class="post-social-facebook">
                                <a href="#"><span>Facebook</span></a>
                            </li>
                            <li class="post-social-twitter">
                                <a href="#"><span>Twitter</span></a>
                            </li>
                            <li class="post-social-linkedin">
                                <a href="#"><span>LinkedIn</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="user-actions">
                        @if(Auth::id() === $user->id)
                            <a href="{{ url('/profiles/' . $user->id . '/edit') }}" class="button button-secondary">Edit Profile</a>
                        @endif
                    </div>
                </div>
                <div class="content">
                    <div class="information">
                        <span class="firstname">{{ $profile->firstname }}</span>
                        <span class="lastname">{{ $profile->lastname }}</span>
                    </div>
                    <div class="bio">"{{ $profile->bio }}"</div>
                    <div class="post-overview">
                        <dl>
                            <dt>First Name</dt>
                            <dd>{{ $profile->firstname }}</dd>
                            <dt>Last Name</dt>
                            <dd>{{ $profile->lastname }}</dd>
                            <dt>Location</dt>
                            <dd>{{ $profile->location }}</dd>
                            <dt>Birthdate</dt>
                            <dd>{{ $profile->birthdate }}</dd>
                            <dt>Gender</dt>
                            <dd>{{ $profile->gender }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            @if(sizeof($user->events) > 0)
                <div class="related products">
                    <h2>Going To</h2>

                    <ul class="products">
                        @foreach ($user->events as $event)
                            <li class="product">
                                <a href="{{ url('/events', $event->id) }}" class="woocommerce-LoopProduct-link">
                                    <div class="product-image-wrapper">
                                        <img width="400" height="340" src="{{ '/images/' . $event->image }}" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">
                                    </div>

                                    <div class="product-date">
                                        <span class="day">{{ date('d', strtotime($event->startdate))}}</span><span class="month">{{ date('M', strtotime($event->startdate)) }}</span><span class="year">{{ date('Y', strtotime($event->startdate)) }}</span>
                                    </div>

                                    <h3>{{ $event->title }}</h3>

                                    <div class="product-location">
                                        {{ $event->location }}
                                    </div>

                                    <span class="onsale">0 minutes</span>
                                    <span class="price">
                                        <span class="woocommerce-Price-amount amount">{{ $event->price}} {{ $event->currency }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(sizeof($user->myevents) > 0)
                <div class="related products">
                    <h2>My Events</h2>

                    <ul class="products">
                        @foreach ($user->myevents as $event)
                            <li class="product">
                                <a href="{{ url('/events', $event->id) }}" class="woocommerce-LoopProduct-link">
                                    <div class="product-image-wrapper">
                                        <img width="400" height="340" src="{{ '/images/' . $event->image }}" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">
                                    </div>

                                    <div class="product-date">
                                        <span class="day">{{ date('d', strtotime($event->startdate))}}</span><span class="month">{{ date('M', strtotime($event->startdate)) }}</span><span class="year">{{ date('Y', strtotime($event->startdate)) }}</span>
                                    </div>

                                    <h3>{{ $event->title }}</h3>

                                    <div class="product-location">
                                        {{ $event->location }}
                                    </div>

                                    <span class="onsale">0 minutes</span>
                                    <span class="price">
                                        <span class="woocommerce-Price-amount amount">{{ $event->price}} {{ $event->currency }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- End   Profile Page -->
        </div>
    </div>
</div>
@endsection