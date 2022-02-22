<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>{{ config('app.name') }} - @yield('title')</title>

  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
  <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
  @yield('css_after')

  <!-- Scripts -->
</head>

<body>
  <div id="page-loader" class="show"></div>
  <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed">

    <nav id="sidebar" aria-label="Main Navigation">
      <!-- Side Header -->
      <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="/">
          <span class="smini-hide">
            <span class="font-w700 font-size-h5">{{ config('app.name') }}</span></span>
          </span>
        </a>
        <!-- END Logo -->
        <div>
          <a class="d-lg-none text-dual ml-3" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
            <i class="fa fa-times"></i>
          </a>
          <!-- END Close Sidebar -->
        </div>
      </div>
      <!-- END Side Header -->

      <!-- Side Navigation -->
      <div class="content-side content-side-full">
        <ul class="nav-main">
          <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('dashboard') }}">
              <i class="nav-main-link-icon fa fa-tachometer-alt"></i>
              <span class="nav-main-link-name">Dashboard</span>
            </a>
          </li>
          @can('Administer work orders')
          <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('workOrder') }}">
              <i class="nav-main-link-icon fa fa-tasks"></i>
              <span class="nav-main-link-name">Work Orders</span>
            </a>
          </li>
          @endcan
          <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('requests.index') }}">
              <i class="nav-main-link-icon fa fa-flag"></i>
              <span class="nav-main-link-name">Requests</span>
            </a>
          </li>
          @hasanyrole('Admin|Asset Manager')
          <li class="nav-main-heading">Access Control</li>
          <li class="nav-main-item 
          {{ (request()->is('users*') || 
            request()->is('roles*') || 
            request()->is('permissions*')) ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <i class="nav-main-link-icon fa fa-user"></i>
              <span class="nav-main-link-name">Users Management</span>
            </a>
            <ul class="nav-main-submenu">
              @can('List users')
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('users*')) ? 'active' : '' }}" href="{{ route('users.index') }}">
                  <span class="nav-main-link-name">Users</span>
                </a>
              </li>
              @endcan
              @can('Administer roles & permissions')
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('roles*')) ? 'active' : '' }}" href="{{ route('roles.index') }}">
                  <span class="nav-main-link-name">Roles</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('permissions*')) ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                  <span class="nav-main-link-name">Permissions</span>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('Admin|Asset Manager|IT Support')
          <li class="nav-main-heading">Assets Management</li>
          <li class="nav-main-item {{ (request()->is('machines*')) ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <i class="nav-main-link-icon fa fa-desktop"></i>
              <span class="nav-main-link-name">Machines</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('machines')) ? 'active' : '' }}" href="{{ route('machines.index') }}">
                  <span class="nav-main-link-name">All Machines</span>
                </a>
              </li>
              @can('Create machines')
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('machines/create')) ? 'active' : '' }}" href="{{ route('machines.create') }}">
                  <span class="nav-main-link-name">Create New Machine</span>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          <li class="nav-main-item {{ (request()->is('licenses*')) ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <i class="nav-main-link-icon fa fa-compact-disc"></i>
              <span class="nav-main-link-name">Licenses</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('licenses')) ? 'active' : '' }}" href="{{ route('licenses.index') }}">
                  <span class="nav-main-link-name">All Licenses</span>
                </a>
              </li>
              @can('Create licenses')
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('licenses/create')) ? 'active' : '' }}" href="{{ route('licenses.create') }}">
                  <span class="nav-main-link-name">Create New License</span>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @can('Administer settings')
          <li class="nav-main-item {{ (request()->is('locations*') || request()->is('machine-types*') || request()->is('operating-systems*') || request()->is('status*') || request()->is('software-types*')) ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <i class="nav-main-link-icon fa fa-cog"></i>
              <span class="nav-main-link-name">Settings</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('locations')) ? 'active' : '' }}" href="{{ route('locations.index') }}">
                  <span class="nav-main-link-name">All Locations</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('machine-types*')) ? 'active' : '' }}" href="{{ route('machine-types.index') }}">
                  <span class="nav-main-link-name">All Machine Type</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('operating-systems')) ? 'active' : '' }}" href="{{ route('operating-systems.index') }}">
                  <span class="nav-main-link-name">All Operating System</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('status')) ? 'active' : '' }}" href="{{ route('status.index') }}">
                  <span class="nav-main-link-name">All Status</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('software-types*')) ? 'active' : '' }}" href="{{ route('software-types.index') }}">
                  <span class="nav-main-link-name">All Software Type</span>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @can('View reports')
          <li class="nav-main-item {{ (request()->is('reports*')) ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <i class="nav-main-link-icon fa fa-chart-bar"></i>
              <span class="nav-main-link-name">Reports</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link {{ (request()->is('reports/activity')) ? 'active' : '' }}" href="{{ route('reports.activity') }}">
                  <span class="nav-main-link-name">Activity Report</span>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @endhasanyrole
        </ul>
      </div>
      <!-- END Side Navigation -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
      <!-- Header Content -->
      <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
          <!-- Toggle Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
          <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
          </button>
          <!-- END Toggle Sidebar -->

          <!-- Toggle Mini Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
          <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
            <i class="fa fa-fw fa-ellipsis-v"></i>
          </button>
          <!-- END Toggle Mini Sidebar -->

        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
          <!-- User Dropdown -->
          @auth
          <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if(is_null(Auth::user()->getMedia('avatars')->first()))
              <img class="rounded" src="/media/avatars/avatar0.jpg" alt="Header Avatar" style="width: 18px;">
              @else
              <img class="rounded" src="{{ Auth::user()->getMedia('avatars')->first()->getUrl('thumb') }}" alt="Header Avatar" style="width: 18px;">
              @endif
              <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->first_name }}</span>
              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
              <div class="p-3 text-center bg-primary">
                @if(is_null(Auth::user()->getMedia('avatars')->first()))
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="/media/avatars/avatar0.jpg" alt="">
                @else
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ Auth::user()->getMedia('avatars')->first()->getUrl('thumb') }}" alt="">
                @endif
              </div>
              <div class="p-2">
                <h5 class="dropdown-header text-uppercase">User Options</h5>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('profile') }}">
                  <span>Profile</span>
                  <i class="si si-user"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('preferences') }}">
                  <span>Settings</span>
                  <i class="si si-settings"></i>
                </a>
                <div role="separator" class="dropdown-divider"></div>
                <h5 class="dropdown-header text-uppercase">Actions</h5>

                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  <span>{{ __('Sign Out') }}</span>
                  <i class="si si-logout ml-1"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>

              </div>
            </div>
          </div>
          @endauth
          <!-- END User Dropdown -->

          <!-- Notifications Dropdown -->
          <div id="notifications" class="dropdown-notifications dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="si si-bell"></i>
              <span class="notifications-count badge badge-primary badge-pill">
                {{ Auth::user()->unreadNotifications->count() }}
              </span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-notifications-dropdown">
              <div class="p-2 bg-primary text-center">
                <h5 class="dropdown-header text-uppercase text-white">Notifications</h5>
              </div>
              <ul class="nav-items mb-0">
                @foreach(Auth::user()->unreadNotifications as $notification)
                <li>
                  <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mr-2 ml-3">
                      <i class="fa fa-fw fa-plus-circle text-info"></i>
                    </div>
                    <div class="media-body pr-2">
                      <div class="font-w600">{{ $notification->data['message'] }}</div>
                      <small class="text-muted">{{ $notification->created_at->format('Y-m-d h:i') }}</small>
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
              @if(Auth::user()->unreadNotifications->count() == 0)
              <div id="no-notifications" class="p-2 border-top">
                <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                  <span>No notifications to show</span>
                </a>
              </div>
              @else
              <div id="mark-as-read" class="p-2 border-top">
                <a class="btn btn-sm btn-light btn-block text-center" href="{{ route('markAsRead') }}">
                  <span>Mark all as read</span>
                </a>
              </div>
              @endif
            </div>
          </div>
          <!-- END Notifications Dropdown -->

        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      <div id="page-header-search" class="overlay-header bg-white">
        <div class="content-header">
          <form class="w-100" action="be_pages_generic_search.html" method="POST">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-danger" data-toggle="layout" data-action="header_search_off">
                  <i class="fa fa-fw fa-times-circle"></i>
                </button>
              </div>
              <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
            </div>
          </form>
        </div>
      </div>
      <!-- END Header Search -->

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-white">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">

      @yield('hero')

      <!-- Page Content -->
      <div class="content content-narrow">
        @yield('content')
      </div>
      <!-- END Page Content -->

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-light">
      <div class="content py-3">
        <div class="row font-size-sm">
          <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">

          </div>
          <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
            <a class="font-w600" href="/">{{ config('app.name') }}</a> &copy; <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->

  </div>
  <!-- END Page Container -->

  @yield('modal')

  @yield('js_before')
  <!-- OneUI Core JS -->
  <script src="{{ asset('js/oneui.core.min.js') }}"></script>
  <script src="{{ asset('js/oneui.app.min.js') }}"></script>
  @yield('js_after')
  @stack('scripts')

  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var pusher = new Pusher('b3ce44532791fc9eb10f', {
        cluster: 'ap1'
      });

      var link = 'notification.{{ Auth::user()->id }}';
      var channel = pusher.subscribe(link);

      var notificationsWrapper = $('.dropdown-notifications');
      var notificationsToggle = notificationsWrapper.find('button[data-toggle]');
      var notificationsCountElem = notificationsToggle.find('.notifications-count');
      var notificationsCount = parseInt(notificationsCountElem[0].innerHTML);
      var notifications = notificationsWrapper.find('ul.nav-items');

      if (notificationsCount <= 0) {
        $('.notifications-count').addClass('d-none');
      }

      channel.bind('App\\Events\\RequestEvent', function(data) {
        console.log(data);
        var existingNotifications = notifications.html();

        var newNotificationHtml = `
          <li>
            <a class="text-dark media py-2" href="javascript:void(0)">
              <div class="mr-2 ml-3">
                <i class="fa fa-fw fa-plus-circle text-info"></i>
              </div>
              <div class="media-body pr-2">
                <div class="font-w600">` + data.message + `</div>
                <small class="text-muted">` + data.date + `</small>
              </div>
            </a>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        document.getElementsByClassName('notifications-count')[0].innerHTML = notificationsCount;
        $('.notifications-count').removeClass('d-none');
        $('#no-notifications').hide();
      });
    });
  </script>
</body>

</html>