@include('partials.includes.header')

    @if ( Auth::check() && (!isset($hideNavbar) || !$hideNavbar) )

        @include('partials.includes.navbar-top')

        <div class="breadcrumb-area">
            <div class="container">
                @yield('breadcrumb')
            </div>
        </div>

    @endif

    @if (trim($__env->yieldContent('main-title')))
      <div class="main-title">
          <div class="container">
          @yield('main-title')
          </div>
      </div>
   @endif

    <div class="content-area-fluid">
            @include('errors.validation-message')
            @include('errors.flash-message')
            @include('errors.notification-message')
            @yield('content')
    </div>

    <div class="modal" id="modalLarge" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

@include('partials.includes.footer')
