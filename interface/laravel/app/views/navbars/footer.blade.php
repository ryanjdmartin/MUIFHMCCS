<div class='navbar footer text-muted navbar-fixed-bottom'>
  <div class='container'>
    <span class='navbar-text' style='margin-left: -10px'>
    @if (Auth::check())
      Last Updated: <span id="update_time"></span>
    @endif
    </span>
    <span class='navbar-text navbar-right'>
      McMaster University
      <img src="{{ asset("img/cresticon.png") }}" style='height: 20px' alt='A McMaster University Website'>
    </span>
  </div>
</div>
