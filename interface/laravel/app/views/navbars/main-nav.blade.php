<div class="navbar navbar-inverse main-nav">
      <?php //initialize id vars
        $building_id = "";
        $room_id = "";
        $hood_id = "";
        $breadcrumbs = "";
        $slash = "";
        switch($level){
          case 'hood':
            $hood = $object;
            $breadcrumbs = "<a id = 'hood' style = 'color:#9d9d9d;' href = '#'>".$hood->name."</a>";
            $object = Room::findOrFail($hood->name);
            $slash = "<font color = '#9d9d9d'> / </font>";
          case 'fumehoods':
            $room = $object;
            $room_id = $room->id;
            $breadcrumbs = "<a id = 'hoods_in' style = 'color:#9d9d9d;' href = '#'>".$room->name."</a>".$slash.$breadcrumbs;
            $object = Building::findOrFail($room->id);
            $slash = "<font color = '#9d9d9d'> / </font>";
          case 'rooms':
            $building = $object;
            $building_id = $building->id;
            $breadcrumbs = "<a id = 'rooms_in' style = 'color:#9d9d9d;' href = '#'>".$building->abbv."</a>".$slash.$breadcrumbs;
            $slash = "<font color = '#9d9d9d'> / </font>";
          case 'buildings':
            $breadcrumbs = "<a id = 'buildings' style = 'margin-left:5px;color:#9d9d9d;' href ='#'> Buildings</a>".$slash.$breadcrumbs;
        }
        echo $breadcrumbs;
      ?>

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
