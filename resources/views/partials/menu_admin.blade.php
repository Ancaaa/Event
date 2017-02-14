    <div class="site-navigation">
        <div class="menu-primary-container">
            <ul id="menu-primary-1" class="menu">
                <li class="menu-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="menu-item"><a href="{{ route('admin.list_categories') }}">Categories</a></li>
                {{-- <li class="menu-item"><a>Events</a></li> --}}
                {{-- <li class="menu-item"><a>Comments</a></li> --}}
                <li class="menu-item"><a href="{{ route('admin.list_users') }}">Users</a></li>
            </ul>
        </div>
    </div>

    <div class="site-navigation site-navigation-secondary">
        <div class="menu-secondary-container">
            <ul id="menu-secondary" class="menu">
                <li class="menu-item menu-item-type-custom menu-item-object-custom  "><a href="{{ url('/profiles/' . Auth::id()) }}">{{ Auth::user()->name }}</a>
                </li>
                <li class=""><a href="{{ url('/logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
