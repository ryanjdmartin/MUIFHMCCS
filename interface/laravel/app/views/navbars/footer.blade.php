<nav class='navbar footer text-muted navbar-fixed-bottom'>
  <div class='container-fluid'>
    <div class='navbar-left'>
      <p class='navbar-text' style='margin-left: 0px'>
       @if (Auth::check())
        Last Updated: <span id="update_time"></span>
       @endif
      </p>
    </div>
    <div class='navbar-right'>
      <p class='navbar-text'>
       McMaster University&nbsp;&nbsp;
       <img src="{{ asset("img/cresticon.png") }}" style='height: 20px' alt='A McMaster University Website'>
      </p>
    </div>
  </div>
</nav>
