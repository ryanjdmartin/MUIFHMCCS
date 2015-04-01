<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $building))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
      <?php $fumehoods = DB::table('fume_hoods')            
                        ->leftJoin('rooms', 'rooms.id', '=', 'fume_hoods.room_id')
                        ->where('rooms.building_id', '=', $building->id)
                        ->select('fume_hoods.id', 'fume_hoods.name', 'fume_hoods.room_id', 'rooms.name as room_name',
                            'fume_hoods.model', 'fume_hoods.install_date', 
                            'fume_hoods.maintenance_date', 'fume_hoods.notes' )
                        ->get();

      //$fumehoods = FumeHood::where('room_id', =);?>
      <table class = 'table table-bordered table-condensed'>
      <tr>
        <th>Room</th>
        <th>Fume Hood</th>   
        <th>Model</th>
        <th>Install Date</th>
        <th>Maintenance Date</th>
        <th>Notes</th>
      </tr>
      @foreach($fumehoods as $fumehood)
  
        <tr>
          <td><a id = "room{{$fumehood->room_id}}" href = '#'>{{$fumehood->room_name;}}</a></td>
          <td><a id = "fumehood{{$fumehood->id}}" href = '#' >{{$fumehood->name;}}</a></td>
          <td>{{$fumehood->model;}}</td>
          <td>{{$fumehood->install_date;}}</td>
          <td>{{$fumehood->maintenance_date;}}</td>
          <td>{{$fumehood->notes;}}</td>
        </tr>
        <script type = 'text/javascript'>
        $(document).ready(function(){
          $('{{"#room".$fumehood->room_id}}').on('click', function(){
            var url = "{{ URL::to('/fumehoods/').'/'.$fumehood->room_id}}";
            $.get(url, '', function(data){
              $('#mainInfo').html(data);
            });
          });
          $('{{"#fumehood".$fumehood->id}}').on('click', function(){
            var url = "{{ URL::to('/hood/').'/'.$fumehood->id}}";
            $.get(url, '', function(data){
              $('#mainInfo').html(data);
            });
          });
        });
        </script>
      @endforeach
    </table>
    @endif
  </div>
</div>

<script type = 'text/javascript'>
$(document).ready(function(){
  $("#update_time").text("{{date("Y-m-d H:i:s")}}");
  setTimeout(function(){
    var url = "{{ URL::to('/rooms/').'/'.$building->id }}";
    $.get(url, '', function(data){
        $('#mainInfo').html(data);
    });
  }, 900000);

@if(Session::get('isTileView') == 1)
  $('#spinner').spin('tile');
@else
  $('#spinner').spin('list');
@endif
  streamData("spinner", "{{ URL::to('/rooms/stream/') }}", {{$building->id}}, 0);
});
</script>
