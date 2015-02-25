 <div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $room))

<?php $room_id = $room->id;?>

	<div class="main-view">

    @foreach ($fumehoods as $fumehood)
		<div class="tile list-group">
	      <button class="list-group-item btn btn-primary" href='#' id="{{"fumehood".$fumehood->id}}">
	        {{$room->getBuilding()->abbv}} {{$room->name}} Fumehood {{$fumehood->name}}
          </button> 
	      <div class="list-group-item">
            <? $counts = Notification::countHoodNotifications($fumehood->id); ?>
            <? $data = Measurement::where('fume_hood_name', $fumehood->name)->orderBy('measurement_time', 'desc')->first(); ?>
            Status:
            <span class="badge">V: {{$data ? $data->velocity." m/s" : "N/A"}}</span> 
            @if ($counts['critical'])
              <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {{$counts['critical']}}</span>
            @endif
            @if ($counts['alert'])
              <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> {{$counts['alert']}}</span>
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
    @endforeach

	</div>
</div>
