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

            @if(sizeof($user->latestAttending) > 0)
                <div class="related products">
                    <h2>Events {{ $user->name }} is attending</h2>

                    <ul class="products">
                        @foreach ($user->latestAttending as $event)
                            @include('partials.event_summary', ['event' => $event])
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(sizeof($user->myevents) > 0)
                <div class="related products">
                    <h2>Events created by {{ $user->name }}</h2>

                    <ul class="products">
                        @foreach ($user->myevents as $event)
                            @include('partials.event_summary', ['event' => $event])
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- End Profile Page -->
        </div>
    </div>
</div>
@endsection