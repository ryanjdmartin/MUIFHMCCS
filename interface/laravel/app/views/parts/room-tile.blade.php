		<div class="tile list-group" style='display:none' id='tile{{$last_id}}'>
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
            <? $opt = max($room->countFumeHoods() - $counts['critical'] - $counts['alert'], 0); ?>
            @if ($opt)
            <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span> {{$opt}}</span> 
            @endif
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
