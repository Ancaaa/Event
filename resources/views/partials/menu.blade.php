@if (Auth::guest())
    <div class="site-navigation">
        <div class="menu-primary-container">
            <ul id="menu-primary-1" class="menu">
                <li class=""><a href="{{ url('/') }}">Home</a></li>
                <li class=""><a href="{{ url('/allevents')}}">Find Events</a></li>
            </ul>

            <ul id="welcome-menu" class="menu">
                <li class=""><a href="{{ url('/register')}}">Register</a></li>
                <li class=""><a href="{{ url('/login') }}">Login</a></li>
            </ul>
        </div>
    </div>

    <div class="site-navigation-secondary">
        <div class="menu-secondary-container">
            <ul id="menu-secondary" class="menu">
                <li class=""><a href="{{ url('/register')}}">Register</a></li>
                <li class=""><a href="{{ url('/login') }}">Login</a></li>
            </ul>
        </div>
    </div>
@else
    <div class="site-navigation">
        <div class="menu-primary-container">
            <ul id="menu-primary-1" class="menu">
                <li class=""><a href="{{ url('/') }}">Home</a></li>
                <li class=""><a href="{{ url('/allevents')}}">Find Events</a></li>
            </ul>

            <ul id="welcome-menu" class="menu">
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6"><a href="{{ url('/profiles/' . Auth::id()) }}">{{ Auth::user()->name }}</a>
                    <ul class="sub-menu">
                        <li class=""><a href="{{ url('/profiles/' . Auth::id()) }}">My Profile</a></li>
                        <li class=""><a href="{{ url('/events') }}">My Events</a></li>
                        <li class=""><a href="{{ url('/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="site-navigation site-navigation-secondary">
        <div class="menu-secondary-container">
            <ul id="menu-secondary" class="menu">
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6"><a href="{{ url('/profiles/' . Auth::id()) }}">{{ Auth::user()->name }}</a>
                    <ul class="sub-menu">
                        <li class=""><a href="{{ url('/profiles/' . Auth::id()) }}">My Profile</a></li>
                        <li class=""><a href="{{ url('/events') }}">My Events</a></li>
                        <li class=""><a href="{{ url('/logout')}}">Logout</a></li>
                    </ul>
                </li>

                <li id="notifications-trigger" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6">
                    <a>
                        Notifications
                        <span class="unread-container"><span class="unread-number"></span></span>
                    </a>
                    <ul class="sub-menu notifications-menu" id="notifications-sub-menu"></ul>
                </li>
            </ul>
        </div>
    </div>
@endif