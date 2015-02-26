<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">MUIFHMCCS</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse navbar-right">
      <ul class="nav navbar-nav">
        @if (Auth::check())
        <li><a href="{{ route('home') }}">Home</a><li>
          @if (Auth::user()->isAdmin())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tools <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('users.view') }}">Manage Users</a></li>
              <li><a href="#">System Settings</a></li>
            </ul>
          </li>
          @endif
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->email }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('user.profile') }}">Profile</a></li>
            <li><a href="{{ route('user.logout') }}">Log Out</a></li>
          </ul>
        </li>
        @else
        <li><a href="{{ route('user.login') }}">Log In</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
