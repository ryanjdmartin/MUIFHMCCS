 <div class="main">
@include('navbars.main-nav')

	<div class="main-view">

	<h1>Fumehoods in Room {{$room_id}}</h1>

	<?php

	foreach($fumehoods as $fumehood)
	{
		$name = $fumehood->name;
		$id = $fumehood->id;
		$model = $fumehood->model;
		$install_date = $fumehood->install_date;
		$maintenence_date = $fumehood->maintenence_date;
		$notes = $fumehood->notes;
	?>

		<div class="btn-group btn-group-vertical" style="margin-right:10px">
	        <button class="btn btn-primary btn-lg" type ='button' id = {{"fumehood$id"}} style="width: 200px; height:100px; margin-bottom:0px; border-top-right-radius:6px;"\>
	        	{{$name}}</button> 
	        <button class="btn btn-info btn-lg" style="width: 200px;
	          height:50px; margin-bottom: 20px;border-bottom-left-radius:6px">Alerts</button> 
	     </div>
	     	<script type = 'text/javascript'>
			$(document).ready(function(){
				$('{{"#fumehood$id"}}').on('click', function(){
					//alert('We click');
					//var login_form = $('#login_form').serializeArray();
					var url = "{{ URL::to('/hood/').'/'.$id  }}";
					$.get(url, '', function(data){
						$('#mainInfo').html(data);
					});
				});
			});
			</script>
	<?php } ?>

	</div>
</div>