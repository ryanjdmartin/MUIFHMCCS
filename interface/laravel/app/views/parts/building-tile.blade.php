		<div class="tile list-group" style='display:none' id='tile{{$last_id}}'>
	      <button class="list-group-item btn btn-primary" href='#' id="{{"building".$building->id}}">
            <!--Building {{$building->id}}
            <br> -->
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
            <? $opt = max($building->countFumeHoods() - $counts['critical'] - $counts['alert'], 0); ?>
            @if ($opt)
            <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span> {{$opt}}</span> 
            @endif
          </div> 
	     </div>
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
