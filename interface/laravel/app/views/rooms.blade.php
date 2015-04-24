<div class="main">
@include('navbars.main-nav', array('level' => 'rooms', 'object' => $building))
  <div class="main-view">
    @if(Session::get('isTileView') == 1)
      <div class="spinner-container" id="spinner" ></div>
    @else
      <table class = 'table table-bordered table-condensed table-striped table-hover'>
      <thead>
      <tr>
        <th class = "filterable">Room</th>
        <th class = "filterable">Fume Hood</th>   
        <th class = "filterable">Status</th>
        <th class = "filterable">Current Airflow</th>
        <th class = "filterable">Notes</th>
        </tr>
        <tr>
          <th><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
          <th><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
          <th><select onchange="Table.filter(this,this)">
                <option value="function(){return true;}">All</option>
                <option value="function(val){return val=='C';}">Critical</option>
                <option value="function(val){return val=='A';}">Alert</option>
                <option value="function(val){return val=='O';}">Clear</option>
                <option value="function(val){return val=='C'||val=='A';}">Critical + Alert</option>
              </select>
          </th>
          <th><select onchange="Table.filter(this,this)">
                <option value="function(){return true;}">All</option>
                <option value="function(val){return parseFloat(val.replace('cft/min',''))>100;}">&gt; 100 cft/min</option>
                <option value="function(val){return parseFloat(val.replace('cft/min',''))<=100;}">&lt;= 100 cft/min</option>
              </select>
          </th>
          <th><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
        </tr>
      </thead>
        <tr id = 'insert' style='border-style:hidden'><td colspan=5 style='border-style:hidden'><div id="spinner" style='height:20px'></div></td></tr>
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
  streamData("spinner", "{{ URL::to('/rooms/stream/') }}", {{$building->id}});
});
</script>
