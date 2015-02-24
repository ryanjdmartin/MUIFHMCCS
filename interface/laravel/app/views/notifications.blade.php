  <div class="sidebar" id="sidebar">
    <div class="panel panel-default sidebar-panel">
      <div class="panel-heading">
	    <h4 class="panel-title">
	      Notifications 
          <div class='pull-right'>
            <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> 2</span>
            <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> 5</span>
          </div>
	    </h4>
      </div>
      <div class="notifications" id="notifications-list">
        <table class="table table-bordered table-striped table-hover">
          @foreach ($notifications as $n)
            @if ($n->class == 'critical')
            <tr>
              <td class='alert-danger'>
                <span class='text-danger'>
                  <span class="glyphicon glyphicon-exclamation-sign"></span>
            @elseif ($n->class == 'alert')
            <tr>
              <td class='alert-warning'>
                <span class='text-warning'>
                  <span class="glyphicon glyphicon-info-sign"></span>
            @endif
                  <b>{{ $n->type }}</b>
                </span>
                <br>
                <span class="badge">{{ strtoupper($n->status) }}</span>
                <span class="pull-right">
                  <span class="glyphicon glyphicon-comment"></span>
                </span>
                <br>
                <? $f = FumeHood::where('name', $n->fume_hood_name)->firstOrFail(); ?>
                <a href="#{{ $f->getRoom()->building_id }}">{{ $f->getBuilding()->abbv }}</a> 
                    / <a href="#{{ $f->room_id }}">{{ $f->getRoom()->name }}</a> 
                    / <a href='#'>{{ $n->fume_hood_name }}</a>
                <br>
                Updated At: {{ ($n->updated_at > $n->measurement_time ? $n->updated_at : $n->measurement_time) }}
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
