<div class="navbar navbar-inverse main-nav">
  <div class="navbar-left">
    <ul class ="nav navbar-nav">
      @if($level == 'buildings')
        Buildings
      @elseif($level == 'rooms')
        <li><a id = 'buildings' href ="#";> Buildings</a></li>
      @elseif($level == 'fumehoods')
        <li><a id = 'buildings' href ="#";> Buildings</a></li>
      @elseif($level == 'hood')
        <li><a id = 'buildings' href ="#";> Buildings</a></li>
      @endif
      <script type = 'text/javascript'>
      $(document).ready(function(){
        $('#buildings').on('click', function(){
          //alert('We click');
          $('#mainInfo').load("{{ URL::to('/buildings') }}");
        });
      });
      </script>
   </ul>
 </div>
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
