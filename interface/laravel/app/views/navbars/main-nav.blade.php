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
            $hood_name = $hood->name;
            $breadcrumbs = "<a id = 'hood' style = 'color:#9d9d9d;' href = '#'>".$hood->name."</a>";
            $object = Room::findOrFail($hood->room_id);
            $slash = "<font color = '#9d9d9d'> / </font>";
          case 'fumehoods':
            $room = $object;
            $room_id = $room->id;
            $breadcrumbs = "<a id = 'hoods_in' style = 'color:#9d9d9d;' href = '#'>".$room->name."</a>".$slash.$breadcrumbs;
            $object = Building::findOrFail($room->building_id);
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
  
  <div class="navbar-right pull-right">
    <ul class="nav navbar-nav">
      <li>
        <a id ='toggleTileView' href="#">
          <span class="glyphicon glyphicon-th"></span>
        </a>
      </li>
      <li>
        <a id = 'toggleListView' href="#">
          <span class="glyphicon glyphicon-th-list"></span>
        </a>
      </li>
    </ul>
  </div>

  <script>
    $(document).ready(function(){
        if(isMobile()){
            var toggle = document.getElementById('toggleTileView');
            toggle.style.display = 'none';
            var toggle = document.getElementById('toggleListView');
            toggle.style.display = 'none';
        }
      });
  </script>
  <?php
    //Get current url for the view toggles
    $currentURL = "";
    if($level == 'hood'){
      $currentURL = URL::to('/hoods/').'/'.$hood_name;
    }
    elseif($level == 'fumehoods'){
      $currentURL = URL::to('/fumehoods').'/'.$room_id;
    }
    elseif($level == 'rooms'){
      $currentURL = URL::to('/rooms').'/'.$building_id;
    }
    elseif($level == 'buildings'){
      $currentURL = URL::to('/buildings');
    }
  ?>
  <script type = 'text/javascript'>
      $(document).ready(function(){
        $('#buildings').on('click', function(){
          $('#mainInfo').load("{{ URL::to('/buildings') }}");
        });
        $('#rooms_in').on('click', function(){
          $('#mainInfo').load("{{ URL::to('/rooms').'/'.$building_id }}");
        });
        $('#hoods_in').on('click', function(){
          $('#mainInfo').load("{{ URL::to('/fumehoods').'/'.$room_id }}");
        });
        $('#toggleTileView').on('click', function(){
          var url = "{{ URL::to('/toggleview/1') }}";
          //alert(url);
          $.post(url, '', function(data){
            //alert("Success!");
            $('#mainInfo').load("{{$currentURL;}}");
          });
        });
        $('#toggleListView').on('click', function(){
          var url = "{{ URL::to('/toggleview/0') }}";
          //alert("{{$currentURL;}}");
          $.post(url, '', function(data){
            //alert("Success!");
            $('#mainInfo').load("{{$currentURL;}}");
          });
        });
      });
  </script>

</div>


