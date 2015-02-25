<div class="navbar navbar-inverse main-nav">
  <div class="navbar-left">
    <ul class ="nav navbar-nav">
      <?php //initialize id vars
        $building_id = "";
        $room_id = "";
        $hood_id = "";
      ?>
      @if($level == 'buildings')
        <li><a href ="#";> Buildings</a></li>
      @elseif($level == 'rooms')
        <!--Recieves building parent object -->
        <?php $building_id = $building->id;
              $building_abbv = $building->abbv;
        ?>
        <li><a id = 'buildings' href ="#";> Buildings /</a></li> 
        <li><a id = 'rooms_in' href ="#";> {{$building_abbv;}} </a></li>
      @elseif($level == 'fumehoods')
        <!--Recieves room parent object-->
        <?php $building = Building::findOrFail($building_id);?>
        <li><a id = 'buildings' href ="#";> Buildings</a></li>
      @elseif($level == 'hood')
        <!--Recieves hood parent object-->
        <li><a id = 'buildings' href ="#";> Buildings</a></li>
      @endif
      <script type = 'text/javascript'>
      $(document).ready(function(){
        $('#buildings').on('click', function(){
          //alert('We click');
          $('#mainInfo').load("{{ URL::to('/buildings') }}");
        });
        $('#rooms_in').on('click', function(){
          //alert('We click');
          $('#mainInfo').load("{{ URL::to('/rooms').'/'.$building_id }}");
        });
        $('#hoods_in').on('click', function(){
          //alert('We click');
          $('#mainInfo').load("{{ URL::to('/fumehoods').'/'.$room_id }}");
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
