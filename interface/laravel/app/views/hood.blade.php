 <div class="main">
@include('navbars.main-nav', array('level' => 'hood', 'object' => $hood))
<? $room = $hood->getRoom() ?>
	<div class="main-view">
 {{ HTML::script("js/Chart.min.js"); }}

	<div class="fumehood-view">
      <table height="100%"><tr>

      <td style="padding-right:15px; vertical-align:top;">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title"><b>{{$hood->getBuilding()->abbv}} {{$room->name}} Fumehood {{$hood->name}}</b></h3> 
        </div>
         <div class="panel-fumehood-body">
          <table class="table table-bordered table-striped">
            <tr><td><b>Model: </b>{{$hood->model}}</td></tr>
            <tr><td><b>Install Date: </b>{{$hood->install_date}}</td></tr>
            <tr><td><b>Last Maintenance Date: </b>{{max($hood->maintenance_date, $hood->install_date)}}</td></tr>
            @if ($room->contact)
            <tr><td><b>Room Contact: </b>{{$room->contact}}<br></td></tr>
            @endif
            @if ($hood->notes)
            <tr><td><b>Notes: </b>{{$hood->notes}}<br></td></tr>
            @endif

            @if ($data)
            <tr><td><b>Current Velocity: </b>{{$data->velocity}} m/s</td></tr>
            <tr><td><b>Current Sash State: </b>{{$data->sash_up ? 'Up (Open)' : 'Down (Closed)'}}</td></tr>
            <tr><td><b>Current Alarm State: </b>{{$data->alarm ? 'True' : 'False'}}</td></tr>
            <tr><td><button class="btn btn-primary btn-xs">Download Fumehood Data as CSV</button></td></tr>
            @endif
            <tr></tr>
          </table>
        </div>
       </div>
      </td>

      @if ($notifications)
      <td style="padding-right:15px; vertical-align:top;">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Notification History</h3>
        </div>
         <div class="panel-fumehood-body">
          <table class="table table-bordered">
          @foreach ($notifications as $n)
            <tr>
            @if ($n->class == 'critical')
              <td class='alert-danger'>
                <span class='text-danger'>
                  <span class="glyphicon glyphicon-exclamation-sign"></span>
            @elseif ($n->class == 'alert')
              <td class='alert-warning'>
                <span class='text-warning'>
                  <span class="glyphicon glyphicon-info-sign"></span>
            @endif
                  <b>{{ $n->type }}</b>
                </span>
                <br>
                  <span class='badge blue'>{{ strtoupper($n->status) }}</span>
                </p>
                <p>
                Updated At: {{ max($n->updated_time, $n->measurement_time) }}
                @if ($n->updated_by)
                  <br>
                  {{ ucfirst($n->status) }} By: {{ User::find($n->updated_by)->email }}
                @endif
                </p>
              </td>
            </tr>
          @endforeach
            <tr></tr>
          </table>
         </div>
        </div>
       </div>
      </td>
      @endif

      @if ($data)
      <td id="velocity" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Velocity: Last 24 Hours</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="velocity_chart" width="300" height="300"></canvas>
            <button class="btn btn-primary btn-xs" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td id="alarm" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Alarm Flag: Last 24 Hours</h3>
        </div>
          <div class="panel-fumehood-body">
            <div class='badge center-block' style='margin-top: 5px'>1: Alarm Raised</div>
            <canvas id="alarm_chart" width="300" height="277"></canvas>
            <button class="btn btn-primary btn-xs" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td id="sash" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Overnight Sash Activity: Last Week</h3>
        </div>
          <div class="panel-fumehood-body">
            <div class='badge center-block' style='margin-top: 5px'>1: Up (Open), 0: Down (Closed)</div>
            <canvas id="sash_chart" width="300" height="277"></canvas>
            <button class="btn btn-primary btn-xs" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td style="padding-right:15px">
        <div id="spinner" style="width: 300px"></div>
      </td>

      <script type="text/javascript">
      $(document).ready(function(){
        $('#spinner').spin('graph');
        loadChart("velocity_chart", "{{ URL::to('/hood/velocity').'/'.$hood->id.'/95' }}", function(){
            $("#velocity").delay(500).fadeIn();
            loadChart("alarm_chart", "{{ URL::to('/hood/alarm').'/'.$hood->id.'/95' }}", function(){
                $("#alarm").delay(500).fadeIn();
                loadChart("sash_chart", "{{ URL::to('/hood/sash').'/'.$hood->id.'/7' }}", function(){
                    $("#sash").delay(500).fadeIn();
                    $('#spinner').spin(false);
                    $('#spinner').hide();
                });
            });
        });
      });
      </script>
      @endif
      </tr></table>
	</div>
</div>
