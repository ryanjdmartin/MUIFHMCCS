 <div class="main">
 {{ HTML::script("js/Chart.min.js"); }}
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

	<div class="fumehood-view">
      <table height="100%"><tr>

      <td style="padding-right:15px; vertical-align:top;">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Fumehood {{$hood->name}} Data <button class='btn btn-xs btn-default' id='refresh'>Ref</button></h3>
        </div>
         <div class="panel-fumehood-body">
          <table class="table table-bordered table-striped">
            <tr><td><b>Location: </b>{{$hood->getBuilding()->abbv}} 
            {{$hood->getRoom()->name}} 
            <tr><td><b>Model: </b>{{$hood->model}}</td></tr>
            <tr><td><b>Install Date: </b>{{$hood->install_date}}</td></tr>
            <tr><td><b>Last Maintenence Date: </b>{{$hood->maintenence_date}}</td></tr>
            <tr><td><b>Notes: </b>{{$hood->notes}}<br></td></tr>

            @if ($data)
            <tr><td><b>Current Velocity: </b>{{$data->velocity}} UNITS</td></tr>
            <tr><td><b>Current Sash State: </b>{{$data->sash_up ? 'Up (Open)' : 'Down (Closed)'}}</td></tr>
            <tr><td><b>Current Alarm State: </b>{{$data->alarm ? 'True' : 'False'}}</td></tr>
            <tr><td><button class="btn btn-default">Download Fumehood Data as CSV</button></td></tr>
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
          <h3 class="panel-title">Current Notifications</h3>
        </div>
         <div class="panel-fumehood-body">
          <table class="table table-bordered">
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
          <h3 class="panel-title">Recent Velocity Activity</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="velocity_chart" width="300" height="300"></canvas>
            <button class="btn btn-default" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td id="sash" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Recent Sash Activity</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="sash_chart" width="300" height="300"></canvas>
            <button class="btn btn-default" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td id="alarm" style="padding-right:15px; vertical-align:top; display:none">
       <div class="panel panel-default panel-fumehood">
        <div class="panel-heading">  
          <h3 class="panel-title">Recent Alarm Flag Activity</h3>
        </div>
          <div class="panel-fumehood-body">
            <canvas id="alarm_chart" width="300" height="300"></canvas>
            <button class="btn btn-default" style="margin:10px">View Full Graph</button>
          </div>
        </div>
       </div>
      </td>

      <td style="padding-right:15px">
        <div id="spinner" style="width: 300px"></div>
      </td>

      <script type="text/javascript">
      $(document).ready(function(){
        //Re-run all this stuff every 15 mins?
        $('#spinner').spin('graph');
        loadChart("velocity_chart", "{{ URL::to('/hood/velocity').'/'.$hood->id.'/100' }}", function(){
            $("#velocity").delay(500).fadeIn();
            loadChart("sash_chart", "{{ URL::to('/hood/sash').'/'.$hood->id.'/100' }}", function(){
                $("#sash").delay(500).fadeIn();
                loadChart("alarm_chart", "{{ URL::to('/hood/alarm').'/'.$hood->id.'/100' }}", function(){
                    $("#alarm").delay(500).fadeIn();
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
