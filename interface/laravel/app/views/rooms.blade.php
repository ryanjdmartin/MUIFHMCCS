<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $building))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
      <table class = 'table table-bordered table-condensed'>
        <tr>
          <th>Room</th>
          <th>Fume Hood</th>   
          <th>Status</th>
          <th>Current Velocity</th>
          <th>Notes</th>
        </tr>
        <tr id = 'insert0'> </tr>
        <tr id = 'insert' style='border-style:hidden'><td colspan=7 style='border-style:hidden'><div id="spinner" style='height:20px'></div></td></tr>
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
