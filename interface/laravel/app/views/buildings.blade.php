<h1>Buildings</h1>

<?php
$buildings = DB::table('buildings')->get();


foreach($buildings as $building)
{
	$name = $building->name;
	$id = $building->id;
	$abbv = $building->abbv;
?>

	<div class="btn-group btn-group-vertical" style="margin-right:10px">
        <button class="btn btn-primary btn-lg" type ='button' id = {{"building$id"}} style="width: 200px; height:100px; margin-bottom:0px; border-top-right-radius:6px;"\>
        	{{$name}}</button> 
        <button class="btn btn-info btn-lg" style="width: 200px;
          height:50px; margin-bottom: 20px;border-bottom-left-radius:6px">Alerts</button> 
     </div>
     	<script type = 'text/javascript'>
		$(document).ready(function(){
			$('{{"#building$id"}}').on('click', function(){
				//alert('We click');
				//var login_form = $('#login_form').serializeArray();
				var url = "{{ URL::to('/rooms/').'/'.$id }}";
				//alert(url);
				$.get(url, '', function(data){
					$('#ajaxTest').html(data);
				});
			});
		});
	</script>
<?php } ?>


