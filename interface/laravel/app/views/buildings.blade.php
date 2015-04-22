<div class="main">
@include('navbars.main-nav', array('level' => 'buildings'))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
    	<table class = 'table table-bordered table-condensed table-striped table-hover'>
			<tr>
			 	<th>Building</th>
		    <th>Room</th>
        <th>Fume Hood</th>   
        <th>Status</th>
        <th>Current Airflow</th>
        <th>Notes</th>
        </tr>
        <tr id = 'insert' style='border-style:hidden'><td colspan=6 style='border-style:hidden'><div id="spinner" style='height:20px'></div></td></tr>
	 	</table>
    @endif
  </div>
</div>

<script type = 'text/javascript'>
$(document).ready(function(){
@if(Session::get('isTileView') == 1)
  $('#spinner').spin('tile');
@else
  $('#spinner').spin('list');
@endif
  streamData("spinner", "{{ URL::to('/buildings/stream/') }}", 0);
});
</script>
