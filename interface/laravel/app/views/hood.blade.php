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
            @if ($hood->notes)
            <tr><td><b>Notes: </b>{{$hood->notes}}<br></td></tr>
            @endif

            @if ($data)
            <tr><td><b>Current Airflow: </b>{{$data->velocity}} cft/min</td></tr>
            <tr><td><b>Current Sash State: </b>{{$data->sash_up ? 'Up (Open)' : 'Down (Closed)'}}</td></tr>
            <tr><td><b>Current Alarm State: </b>{{$data->alarm ? 'True' : 'False'}}</td></tr>
              @if (Auth::user()->isAdmin())
              <tr><td><a class="btn btn-primary btn-xs" href='{{ URL::to("/hood/download/".$hood->id) }}'>Download Fumehood Data as CSV</a></td></tr>
              @endif
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
          <h3 class="panel-title">Airflow: Last 12 Hours</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="velocity_chart" width="300" height="300"></canvas>
            <button class="btn btn-primary btn-xs" style="margin:10px" onClick='fullGraph("velocity")'>View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td id="alarm" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Alarm Flag: Last 12 Hours</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="alarm_chart" width="300" height="300"></canvas>
            <button class="btn btn-primary btn-xs" style="margin:10px" onClick='fullGraph("alarm")'>View Full Graph</button>
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
            <button class="btn btn-primary btn-xs" style="margin:10px" onClick='fullGraph("sash")'>View Full Graph</button>
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
        loadChart("velocity_chart", "{{ URL::to('/hood/velocity').'/'.$hood->id.'/48' }}", function(len){
            if (len){
                $("#velocity").delay(500).fadeIn();
            }
            loadChart("alarm_chart", "{{ URL::to('/hood/alarm').'/'.$hood->id.'/48' }}", function(len){
                if (len){
                    $("#alarm").delay(500).fadeIn();
                }
                loadChart("sash_chart", "{{ URL::to('/hood/sash').'/'.$hood->id.'/7' }}", function(len){
                    if (len){
                        $("#sash").delay(500).fadeIn();
                    }
                    $('#spinner').spin(false);
                    $('#spinner').hide();
                });
            });
        });
      });

      function fullGraph(type){
        if (type == 'sash')
            $('#graph-title').text('Overnight Sash Activity');
        else if (type == 'velocity')
            $('#graph-title').text('Airflow Data (cft/min)');
        else if (type == 'alarm')
            $('#graph-title').text('Alarm State Data');

        $('#graph-modal').modal('show');  
        $('#full-spinner').show();
        $('#full-spinner').spin('graph');
        loadChart("full_chart", "{{ URL::to('/hood')}}/"+type+"/{{$hood->id.'/0' }}", function(len){
            setTimeout(function(){
                if (len){
                    $("#full_chart_div").fadeIn();
                }
                $('#full-spinner').spin(false);
                $('#full-spinner').hide();
            }, 500);
        }, true);
      }
      </script>
      @endif
      </tr></table>
	</div>
</div>

<div class="modal fade" id='graph-modal' tabindex="-1">
  <div class="modal-dialog modal-lg" style='width: 90%'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">{{$hood->getBuilding()->abbv}} {{$room->name}} Fumehood {{$hood->name}}: <span id='graph-title'></span></h4> 
      </div>
      <div class="modal-body">
        <div id="full-spinner" style='width: 100%; height: 500px;'></div>
        <div style='width: 100%; overflow-x: auto; display: none' id='full_chart_div'>
          <canvas id="full_chart" width="100" height="500"></canvas>
        <div>
      </div>
    </div>
  </div>
</div>
