  <div class="sidebar" id="sidebar">
    <div class="panel panel-default sidebar-panel">
      <div class="panel-heading">
	    <h4 class="panel-title">
	      <b>Notifications</b>
          <div class='pull-right'>
            <a href='#' onClick="filterNotifications(this, 'critical', 'danger');"><span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {{$counts['critical']}}</span></a>
            <a href='#' onClick="filterNotifications(this, 'alert', 'warning');"><span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> {{$counts['alert']}}</span></a>
          </div>
	    </h4>
      </div>
      <div class="notifications" id="notifications-list">
        <table class="table table-bordered table-striped table-hover" id="notifications-table">
          @foreach ($notifications as $n)
            <tr>
            @if ($n->status == 'resolved')
              <td class='alert-success' name='{{$n->class}}'>
            @elseif ($n->status == 'acknowledged')
              <td class='alert-info' name='{{$n->class}}'>
            @elseif ($n->class == 'critical')
              <td class='alert-danger' name='{{$n->class}}'>
            @elseif ($n->class == 'alert')
              <td class='alert-warning' name='{{$n->class}}'>
            @endif
            @if ($n->class == 'critical')
                <span class='text-danger'>
                  <span class="glyphicon glyphicon-exclamation-sign"></span>
            @elseif ($n->class == 'alert')
                <span class='text-warning'>
                  <span class="glyphicon glyphicon-info-sign"></span>
            @endif
                  <b>{{ $n->type }}</b>
                </span>
                @if ($n->class == 'critical' && $n->status != 'resolved')
                  <button type="button" class="close" onClick='$("#notification-dismiss-no").modal("show");'><span>&times;</span></button>
                @else
                  <button type="button" class="close" onClick='dismissNotification({{$n->id}});'><span>&times;</span></button>
                @endif
                <br>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="font-weight: bold; font-size; padding: 5px 10px">
                    Status: {{ ucfirst($n->status) }}
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu notification-menu">
                    <li><a href="#">Mark as Acknowledged</a></li>
                    <li><a href="#">Mark as Resolved</a></li>
                  </ul>
                </div>
                </p>
                <p>
                <? $f = FumeHood::where('name', $n->fume_hood_name)->firstOrFail(); ?>
                <a href="#" id="notification_link{{$n->id}}">{{ $f->getBuilding()->abbv }}  
                    {{ $f->getRoom()->name }} Fumehood {{ $n->fume_hood_name }}</a>
                
                <script type="text/javascript">
                  $(document).ready(function(){
				    $('{{"#notification_link".$n->id}}').on('click', function(){
					  var url = "{{ URL::to('/hood/').'/'.$f->id }}";
					  $.get(url, '', function(data){
						$('#mainInfo').html(data);
					  });
				    });
				  });
                </script>
                <br>
                Updated At: {{ max($n->updated_time, $n->measurement_time) }}
                </p>
              </td>
            </tr>
          @endforeach
          @if (!$notifications)
            <tr><td>No current notifications.</td></tr>
          @endif
        </table>
      </div>
    </div>
  </div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" id="notification-dismiss-no">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Cannot Dismiss Notification</h4>
      </div>
      <div class="modal-body">
        <p>This is a critical notification. You cannot dismiss it until its status has been marked as resolved.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" id="notification-dismiss">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Dismiss Notification?</h4>
      </div>
      <div class="modal-body">
        <p>Dismiss this notification?</p>
		{{ Form::open(array('url' => 'notifications/dismiss', 'id' => 'dismiss-form')) }}
        <input type='hidden' name='id' id='dismiss-id' value=''>
        {{ Form::close() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onClick='$("#dismiss-form").submit();'>Dismiss</button>
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#update_time").text("{{date("Y-m-d H:i:s")}}");
      setTimeout(function(){
        //Dont do it if modal is open
          $('#notifications').load("{{ URL::to('/notifications') }}");
      }, 900000);
    });
    
    function filterNotifications(btn, name, cls){
        $("#notifications-table td[name='"+name+"']").fadeToggle();
        $(btn).children("span").toggleClass(cls);
    }
    function dismissNotification(id){
        $("#dismiss-id").val(id);
        $("#notification-dismiss").modal('show');
    }
  </script>  	
