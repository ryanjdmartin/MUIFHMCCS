<div class="main">
@include('navbars.main-nav', array('level' => 'buildings'))
  <div class="main-view">
    @foreach ($buildings as $building)
    	@if(Session::get('isTileView') == 1)
			<div class="tile list-group">
		      <button class="list-group-item btn btn-primary" href='#' id="{{"building".$building->id}}">
	            Building {{$building->id}}
	            <br>
		        {{$building->name}} 
	            <br>
	            ({{$building->abbv}})
	          </button> 
		      <div class="list-group-item">
	            <? $counts = Notification::buildingNotificationStatus($building->id); ?>
	            Fumehoods:
	            @if ($counts['critical'])
	              <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {{$counts['critical']}}</span>
	            @endif
	            @if ($counts['alert'])
	              <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> {{$counts['alert']}}</span>
	            @endif
	            <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span> 
	                {{max($building->countFumeHoods() - $counts['critical'] - $counts['alert'], 0)}}</span>
	          </div> 
		     </div>
	     @endif
	     	<script type = 'text/javascript'>
			$(document).ready(function(){
				$('{{"#building".$building->id}}').on('click', function(){
					var url = "{{ URL::to('/rooms/').'/'.$building->id }}";
					$.get(url, '', function(data){
						$('#mainInfo').html(data);
					});
				});
			});
		</script>
    @endforeach
  </div>
</div>

<script type = 'text/javascript'>
$(document).ready(function(){
  $("#update_time").text("{{date("Y-m-d H:i:s")}}");
  setTimeout(function(){
    var url = "{{ URL::to('/buildings') }}";
    $.get(url, '', function(data){
        $('#mainInfo').html(data);
    });
  }, 900000);
});
</script>
