<div class="main">
@include('navbars.main-nav', array('level' => 'fumehoods', 'object' => $room))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
      <?php $fumehoods = FumeHood::where('room_id', '=', $room->id)->get();?>
      <table class = 'table table-bordered table-condensed'>
      <tr>
        <th>Fume Hood</th>   
        <th>Model</th>
        <th>Install Date</th>
        <th>Maintenance Date</th>
        <th>Notes</th>
      </tr>
      @foreach($fumehoods as $fumehood)
  
        <tr>
          <td><a id = "fumehood{{$fumehood->id}}" href = '#' >{{$fumehood->name;}}</a></td>
          <td>{{$fumehood->model;}}</td>
          <td>{{$fumehood->install_date;}}</td>
          <td>{{$fumehood->maintenance_date;}}</td>
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
    var url = "{{ URL::to('/fumehoods/').'/'.$room->id }}";
    $.get(url, '', function(data){
        $('#mainInfo').html(data);
    });
  }, 900000);

@if(Session::get('isTileView') == 1)
  $('#spinner').spin('tile');
@else
  $('#spinner').spin('list');
@endif
  streamData("spinner", "{{ URL::to('/fumehoods/stream/') }}", {{$room->id}}, 0);
});
</script>
