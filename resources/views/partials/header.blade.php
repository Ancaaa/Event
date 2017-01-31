
<div class="header-wrapper">
    <div class="header">
        <div class="header-inner">
            @if ($experience === 'full')
                <div class="header-content">
                    <div class="site-branding">
                        <div class="site-title">EventU</div>
                    </div>

                    <a href="{{ url('/events/create') }}" class="button button-secondary">Submit Event</a>
                </div>

                <div class="header-bottom">
                    @include('partials.menu')
                </div>
            @else
                <div class="header-minimal">
                    <div class="site-branding">
                        <div class="site-title">EventU</div>
                    </div>

                    @include('partials.menu')
                </div>
            @endif
        </div>
    </div>
</div>
