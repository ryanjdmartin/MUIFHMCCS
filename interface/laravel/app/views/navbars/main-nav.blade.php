<div class="navbar navbar-inverse main-nav">
  <span class='navbar-text'>
      @if($level == 'buildings')
        Buildings
      @elseif($level == 'rooms')
        <a id = 'buildings' href ="#";> Buildings</a>
      @elseif($level == 'fumehoods')
        utu
      @elseif($level == 'hood')
        ijkl
      @endif
      <script type = 'text/javascript'>
      $(document).ready(function(){
        $('#buildings').on('click', function(){
          //alert('We click');
          $('#mainInfo').load("{{ URL::to('/buildings') }}");
        });
      });
      </script>
  </span>

  <div class="navbar-right">
    <ul class="nav navbar-nav">
      <li>
        <a href="javascript:tileView()">
          <span class="glyphicon glyphicon-th"></span>
        </a>
      </li>
      <li>
        <a href="javascript:listView()">
          <span class="glyphicon glyphicon-th-list"></span>
        </a>
      </li>
    </ul>
  </div>
</div>
