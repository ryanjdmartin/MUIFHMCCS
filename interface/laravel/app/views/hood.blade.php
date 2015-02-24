 <div class="main">
@include('navbars.main-nav')

    <script type = 'text/javascript'>
    $(document).ready(function(){
        $('#refresh').on('click', function(){
            var url = "{{ URL::to('/hood/').'/'.$hood->id  }}";
            $.get(url, '', function(data){
                $('#mainInfo').html(data);
            });
        });
    });
    </script>

	<div class="main-view">
      <table height="100%"><tr>

      <td style="padding-right:15px; vertical-align:top;">
       <div class="panel panel-default" style="height: 100%; margin-bottom: 0px; overflow:auto">
        <div class="panel-heading">  
          <h3 class="panel-title">Fumehood {{$hood->name}} Data <button class='btn btn-xs btn-default' id='refresh'>Ref</button></h3>
        </div>
          <table class="panel-body table table-bordered table-striped">
            <tr><td><b>Location: </b>{{$hood->getBuilding()->abbv}} 
            {{$hood->getRoom()->name}} 
            <tr><td><b>Model: </b>{{$hood->model}}</td></tr>
            <tr><td><b>Install Date: </b>{{$hood->install_date}}</td></tr>
            <tr><td><b>Last Maintenence Date: </b>{{$hood->maintenence_date}}</td></tr>
            <tr><td><b>Notes: </b>{{$hood->notes}}</td></tr>

            @if ($data)
            <tr><td><b>Current Velocity: </b>{{$data->velocity}} UNITS</td></tr>
            <tr><td><b>Current Sash State: </b>{{$data->sash_up ? 'Up (Open)' : 'Down (Closed)'}}</td></tr>
            <tr><td><b>Current Alarm State: </b>{{$data->alarm ? 'True' : 'False'}}</td></tr>
            @endif
            <tr></tr>
          </table>
        </div>
       </div>
      </td>

      <td style="padding-right:15px; vertical-align:top;">
       <div class="panel panel-default" style="height: 100%; margin-bottom: 0px; overflow:auto">
        <div class="panel-heading">  
          <h3 class="panel-title">Current Notifications</h3>
        </div>
          <table class="panel-body table table-bordered">
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
                  Updated At: {{ ($n->updated_at > $n->measurement_time ? $n->updated_at : $n->measurement_time) }}
                </td>
              </tr>
            @endforeach
            @if (!$notifications)
              <tr><td>No current notifications.</td></tr>
            @endif
            <tr></tr>
          </table>
        </div>
       </div>
      </td>

      @if ($data)
      @endif
      </tr></table>
	</div>
</div>
