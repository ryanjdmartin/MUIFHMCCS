  <tr style='display:none' id='list{{$last_id}}'>
	<td><a id = "list{{$fumehood->id}}-room{{$fumehood->room_id}}" href = '#'>{{$fumehood->room_name;}}</a></td>
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
	$('#list{{$fumehood->id."-room".$fumehood->room_id}}').on('click', function(){
        var url = "{{ URL::to('/fumehoods/').'/'.$fumehood->room_id}}";
        $.get(url, '', function(data){
          $('#mainInfo').html(data);
        });
      });
	$('#{{"fumehood".$fumehood->id}}').on('click', function(){
		var url = "{{ URL::to('/hood/').'/'.$fumehood->id}}";
		$.get(url, '', function(data){
		  $('#mainInfo').html(data);
		});
	});
});
</script>
