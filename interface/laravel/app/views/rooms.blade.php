<h1>Rooms in Building {{$building_id}}</h1>

<?php
$rooms = DB::table('rooms')->where('building_id', '=', $building_id)->get();


foreach($rooms as $room)
{
	$name = $room->name;
	$id = $room->id;
	$contact = $room->contact;
?>

	<div class="btn-group btn-group-vertical" style="margin-right:10px">
        <button class="btn btn-primary btn-lg" type ='button' id = {{"room$id"}} style="width: 200px; height:100px; margin-bottom:0px; border-top-right-radius:6px;"\>
        	{{$name}}</button> 
        <button class="btn btn-info btn-lg" style="width: 200px;
          height:50px; margin-bottom: 20px;border-bottom-left-radius:6px">Alerts</button> 
     </div>
     	<script type = 'text/javascript'>
		$(document).ready(function(){
			$('{{"#room$id"}}').on('click', function(){
				//alert('We click');
				//var login_form = $('#login_form').serializeArray();
				var url = "{{ URL::to('/fumehoods/').'/'.$id }}";
				//alert(url);
				$.get(url, '', function(data){
					$('#ajaxTest').html(data);
				});
			});
		});
	</script>
<?php } ?>

