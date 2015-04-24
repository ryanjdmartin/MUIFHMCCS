  <tr style='display:none' id='list{{$fumehood->id}}'>
	<td><a id = "fumehood{{$fumehood->id}}" href = '#' >{{$fumehood->name;}}</a></td>
  <?php 
      if ($status == 'critical')
        $statusDisplay = '<label style ="display:none">C</label><span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span></span>';
      elseif ($status == 'alert')
        $statusDisplay = '<label style ="display:none">A</label><span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span></span>';
      else
        $statusDisplay = '<label style ="display:none">O</label><span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span></span>';

      if ($data) 
        $velocityDisplay = $data->velocity."cft/min";
      else
        $velocityDisplay = "N/A";
  ?>
	<td>{{$statusDisplay;}}</td>
	<td>{{$velocityDisplay;}}</td>
	<td>{{$fumehood->notes;}}</td>
  </tr>
<script type = 'text/javascript'>
$(document).ready(function(){			
	$('#{{"fumehood".$fumehood->id}}').on('click', function(){
		var url = "{{ URL::to('/hood/').'/'.$fumehood->id}}";
		$.get(url, '', function(data){
		  $('#mainInfo').html(data);
		});
	});
});
</script>
