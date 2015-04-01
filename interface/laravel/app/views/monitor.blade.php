<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset("favicon.ico") }}">

    <title>MUIFHMCCS</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style("css/bootstrap.min.css"); }}
    {{ HTML::style("css/bootstrap-theme.min.css"); }}

    <!-- Custom CSS -->
    {{ HTML::style("css/fms.css"); }}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{ HTML::script("js/jquery-1.9.1.min.js"); }}
    {{ HTML::script("js/bootstrap.min.js"); }}
    {{ HTML::script("js/spin.min.js"); }}
    {{ HTML::script("js/jquery.spin.js"); }}
    {{ HTML::script("js/Chart.min.js"); }}

    <!-- Custom JS -->
    {{ HTML::script("js/fms.js"); }}
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ route('home') }}">MUIFHMCCS</a>
        </div>
        <div class="navbar-right navbar-text">
          Last Updated: <span id='top_update_time'></span>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
      <div class="col-md-12 monitor">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <b>Critical Notifications <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {{count($critical)}}</span></b>
            </h4>
          </div>
          <div class="monitor-panel">
            <table class="table table-bordered table-striped table-hover" id='critical-table'>
              <tr>
              @foreach ($critical as $n)
                @if ($n->status == 'acknowledged')
                  <td class='alert-info'>
                @else
                  <td class='alert-danger'>
                @endif
                    <b>
                    <span class='text-danger' style='font-size: 16px;'>
                      <span class="glyphicon glyphicon-exclamation-sign"></span>
                      {{ $n->type }}:
                      <? $f = FumeHood::where('name', $n->fume_hood_name)->firstOrFail(); ?>
                      {{ $f->getBuilding()->abbv }} {{ $f->getRoom()->name }} Fumehood {{ $n->fume_hood_name }}
                    </span>
                      <span class='badge {{$n->status == 'new' ? 'danger' : 'blue'}}'>{{ strtoupper($n->status) }}</span>
                    </b>
                    </p>
                    <p>
                    Updated At: {{ max($n->updated_time, $n->measurement_time) }}
                    @if ($n->updated_by)
                      <br>
                      {{ ucfirst($n->status) }} By: {{ User::find($n->updated_by)->email }}
                    @endif
                    </p>
                  <? $data = Measurement::where('fume_hood_name', $n->fume_hood_name)->orderBy('measurement_time', 'desc')->first(); ?>

                  @if ($data)
                    <p>Velocity: Last 24 Hours
                      <div id="spinner-{{$n->id}}" style='height: 200px'>
                        <canvas id="graph-{{$n->id}}" width="575" height="200"></canvas>
                      </div>
                    </p>
                    <script type="text/javascript">
                    $(document).ready(function(){
                      $('#spinner-{{$n->id}}').spin('graph');
                      loadChart("graph-{{$n->id}}", "{{ URL::to('/hood/velocity').'/'.$f->id.'/95' }}", function(){
                        $('#spinner-{{$n->id}}').spin(false);
                      });
                    });
                    </script>
                  @endif
                  </td>
              @endforeach
              </tr>
              @if (!$critical)
                <td>No current critical notifications.</td>
              @endif
            </table>
          </div>
        </div>
      </div>
      </div>

      <div class="row">
      <div class="col-md-12 monitor">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <b>Alert Notifications <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> {{count($alert)}}</span></b>
            </h4>
          </div>
          <div class="monitor-panel">
            <table class="table table-bordered table-striped table-hover" id='alert-table'>
              <tr>
              @foreach ($alert as $n)
                  <td class='alert-warning'>
                    <b>
                    <span class='text-warning' style='font-size: 16px;'>
                      <span class="glyphicon glyphicon-info-sign"></span>
                      {{ $n->type }}
                      <br>
                      <? $f = FumeHood::where('name', $n->fume_hood_name)->firstOrFail(); ?>
                      {{ $f->getBuilding()->abbv }} {{ $f->getRoom()->name }} Fumehood {{ $n->fume_hood_name }}
                    </span>
                    </b>
                    </p>
                    <p>
                    Updated At: {{ max($n->updated_time, $n->measurement_time) }}
                    </p>
                  </td>
              @endforeach
              </tr>
              @if (!$alert)
                <td>No current alert notifications.</td>
              @endif
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        @if (count($critical) > 1)
          marquee("#critical-table", 12000);
        @endif
        @if (count($alert) > 1)
          marquee("#alert-table", 4000);
        @endif
        
        $("#update_time").text("{{date("Y-m-d H:i:s")}}");
        $("#top_update_time").text("{{date("Y-m-d H:i:s")}}");
        setTimeout(function(){
            location.reload(true);
        }, 900000);
      });
    
      function marquee(tbl, timeout){
        setTimeout(function(){
          $(tbl+" td:first").fadeOut(2000, function(){
            $(this).insertAfter($(tbl+" td:last")).fadeIn(2000);
            marquee(tbl, timeout);
          });
        }, timeout);
      }        
    </script>

    @include('navbars.footer')
    
  </body>
</html>
