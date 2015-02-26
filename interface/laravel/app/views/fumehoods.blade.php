<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $room))
  <div class="main-view">
    <div class="spinner-container" id="spinner" ></div>
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

  $('#spinner').spin('tile');
  streamData("spinner", "{{ URL::to('/fumehoods/stream/') }}", {{$room->id}}, 0);
});
</script>
