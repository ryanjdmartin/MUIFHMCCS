<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $building))
  <div class="main-view">
    @foreach ($rooms as $room)
		<div class="tile list-group">
	      <button class="list-group-item btn btn-primary" href='#' id="{{"room".$room->id}}">
	        {{$building->abbv}} Room {{$room->name}}
          </button> 
	      <div class="list-group-item">
            <? $counts = Notification::roomNotificationStatus($room->id); ?>
            Fumehoods:
            @if ($counts['critical'])
              <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {{$counts['critical']}}</span>
            @endif
            @if ($counts['alert'])
              <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> {{$counts['alert']}}</span>
            @endif
            <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span> 
                {{max($room->countFumeHoods() - $counts['critical'] - $counts['alert'], 0)}}</span>
          </div> 
	     </div>
	     	<script type = 'text/javascript'>
			$(document).ready(function(){
				$('{{"#room".$room->id}}').on('click', function(){
					var url = "{{ URL::to('/fumehoods/').'/'.$room->id }}";
					$.get(url, '', function(data){
						$('#mainInfo').html(data);
					});
				});
			});
		</script>
    @endforeach
  </div>
</div>
