		<div class="tile list-group" style='display:none' id='tile{{$fumehood->id}}'>
	      <button class="list-group-item btn btn-primary" href='#' id="{{"fumehood".$fumehood->id}}">
	        {{$room->getBuilding()->abbv}} {{$room->name}} Fumehood {{$fumehood->name}}
          </button> 
	      <div class="list-group-item">
            <? $counts = Notification::countHoodNotifications($fumehood->id); ?>
            Status:
            @if ($counts['critical'])
              <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span></span>
            @elseif ($counts['alert'])
              <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span></span>
            @else
              <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span></span>
            @endif
          </div> 
	     </div>
	     	<script type = 'text/javascript'>
			$(document).ready(function(){
				$('{{"#fumehood".$fumehood->id}}').on('click', function(){
					var url = "{{ URL::to('/hood/').'/'.$fumehood->id }}";
					$.get(url, '', function(data){
						$('#mainInfo').html(data);
					});
				});
			});
		</script>
