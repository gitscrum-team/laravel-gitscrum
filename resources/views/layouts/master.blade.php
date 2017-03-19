@include('partials.includes.header')

<div class="ui sidebar inverted vertical menu">
    <a class="item">
        1
    </a>
    <a class="item">
        2
    </a>
    <a class="item">
        3
    </a>
    <a class="item">
        1
    </a>
    <a class="item">
        2
    </a>
    <a class="item">
        3
    </a>
    <a class="item">
        1
    </a>

</div>
<div class="pusher">

    @if ( Auth::check() && (!isset($hideNavbar) || !$hideNavbar) )

        @include('partials.includes.menubar')

    @endif

    <div class="ui main container center">

        @if (trim($__env->yieldContent('header-title')))
        <h2 class="ui dividing header">@yield('header-title')
            @if (trim($__env->yieldContent('header-subtitle')))
            <div class="sub header">@yield('header-subtitle')</div>
            @endif
        </h2>
        @endif

        @if (trim($__env->yieldContent('breadcrumb')))
            <div class="ui small breadcrumb">
                @yield('breadcrumb')
            </div>
        @endif

        <div class="ui main container">
            @include('errors.validation-message')
            @include('errors.flash-message')
            @include('errors.notification-message')
            @yield('content')
        </div>

    </div>

</div>

<div class="ui modal default-modal">
    <i class="close icon"></i>
    <div class="header">
        Modal Title
    </div>
    <div class="image content">
        <div class="image">
            An image can appear on left or an icon
        </div>
        <div class="description">
            A description can appear on the right
        </div>
    </div>
    <div class="actions">
        <div class="ui button">Cancel</div>
        <div class="ui button">OK</div>
    </div>
</div>

@include('partials.includes.footer')
