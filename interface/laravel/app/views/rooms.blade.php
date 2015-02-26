<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $building))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
      <?php $fumehoods = DB::table('fume_hoods')            
                        ->leftJoin('rooms', 'rooms.id', '=', 'fume_hoods.room_id')
                        ->where('rooms.building_id', '=', $building->id)
                        ->select('fume_hoods.id', 'fume_hoods.name', 'fume_hoods.room_id',
                            'fume_hoods.model', 'fume_hoods.install_date', 
                            'fume_hoods.maintenence_date', 'fume_hoods.notes' )
                        ->get();

      //$fumehoods = FumeHood::where('room_id', =);?>
      <table class = 'table'>
      <tr>
        <th>id</th>
        <th>name</th>
        <th>room_id</th>
        <th>model</th>
        <th>install_date</th>
        <th>maintenance_date</th>
        <th>notes</th>
      </tr>
      @foreach($fumehoods as $fumehood)
  
        <tr>
          <td>{{$fumehood->id;}}</td>
          <td><a id = "fumehood{{$fumehood->id}}" href = '#' >{{$fumehood->name;}}</a></td>
          <td>{{$fumehood->room_id;}}</td>
          <td>{{$fumehood->model;}}</td>
          <td>{{$fumehood->install_date;}}</td>
          <td>{{$fumehood->maintenence_date;}}</td>
          <td>{{$fumehood->notes;}}</td>
        </tr>
        <script type = 'text/javascript'>
        $(document).ready(function(){
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
