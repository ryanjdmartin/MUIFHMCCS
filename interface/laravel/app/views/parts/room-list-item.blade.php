  <tr style='display:none' id='list{{$fumehood->id}}'>
	<td><a id = "list{{$fumehood->id}}-room{{$fumehood->room_id}}" href = '#'>{{$fumehood->room_name;}}</a></td>
	<td><a id = "fumehood{{$fumehood->id}}" href = '#' >{{$fumehood->name;}}</a></td>
	<td>
            @if ($status == 'critical')
              <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span></span>
            @elseif ($status == 'alert')
              <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span></span>
            @else
              <span class="badge opt"><span class="glyphicon glyphicon-ok-circle"></span></span>
            @endif
	</td>
	<td>@if ($data) 
			{{$data->velocity}} m/s
		@else
			N/A
		@endif
	</td>
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
