@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Manage Fumehoods
    </h1>
  </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Manage Buildings <button class='pull-right btn btn-success btn-sm' data-toggle='modal' data-target='#building-modal' style='margin-top: -6px' >Add New Building</button></h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='building-table'>
            <thead>
                <tr>
                    <th class='col-xs-7'>
                        Full Name
                    </th>
                    <th class='col-xs-2'>
                        Abbreviation
                    </th>
                    <th class='col-xs-3'>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($buildings as $b)
                <tr>
                    {{Form::open(array('url' => 'admin/buildings/update'))}}
                    <input type='hidden' name='id' value='{{$b->id}}'>
                    <td class='col-xs-7'>
                      <div class='form-group' style='margin-bottom: 0px'>
                        <input type='text' value='{{$b->name}}' name='name' class='form-control'>
                      </div>
                    </td>
                    <td class='col-xs-2'>
                      <div class='form-group' style='margin-bottom: 0px'>
                        <input type='text' value='{{$b->abbv}}' name='abbv' class='form-control'>
                      </div>
                    </td>
                    <td class='col-xs-3'>
                        <button type='submit' class='btn btn-success'>Save</button>
                        <button type='button' class='btn btn-danger' onClick='conf("Delete Building", "{{$b->name}}", "{{URL::to("admin/buildings/remove/".$b->id)}}")'>Delete</button>
                    </td>
                    {{Form::close()}}
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <div class="col-md-5">
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Manage Rooms <button class='pull-right btn btn-success btn-sm' data-toggle='modal' data-target='#room-modal' style='margin-top: -6px' >Add New Room</button></h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='room-table'>
            <thead>
                <tr>
                    <th class='col-xs-3'>
                        Building
                    </th>
                    <th class='col-xs-6'>
                        Room Name
                    </th>
                    <th class='col-xs-3'>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($rooms as $r)
                <? $b = $r->getBuilding()->abbv ?>
                <tr>
                    <td class='col-xs-3'>
                        {{$b}}
                    </td>
                    <td class='col-xs-6'>
                        {{$r->name}}
                    </td>
                    <td class='col-xs-3'>
                        <button type='button' class='btn btn-xs btn-danger' onClick='conf("Delete Room", "{{$b}} {{$r->name}}", "{{URL::to("admin/rooms/remove/".$r->id)}}")'>Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Manage Fumehoods</h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='fumehoods-table'>
            <thead>
                <tr>
                    <th class='col-xs-1 filterable'>
                        Building
                    </th>
                    <th class='col-xs-1 filterable'>
                        Room
                    </th>
                    <th class='col-xs-2 filterable'>
                        Name
                    </th>
                    <th class='col-xs-2 filterable'>
                        Model
                    </th>
                    <th class='col-xs-1 filterable'>
                        Install Date
                    </th>
                    <th class='col-xs-2 filterable'>
                        Maintenance Date
                    </th>
                    <th class='col-xs-2 filterable'>
                        Notes
                    </th>
                    <th class='col-xs-1'>
                        Actions
                    </th>
                </tr>
                <tr>
                    <th class='col-xs-1'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-1'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-2'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-2'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-1'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-2'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-2'><input name="filter" size="8" onkeyup="Table.filter(this,this)" placeholder="Filter"></th>
                    <th class='col-xs-1'></th>
                </tr>
            </thead>
            <tbody style='max-height: 400px' >
              <tr id = 'insert' style='border-style:hidden'><td colspan=8 style='border-style:hidden; width: 100%'><div id="spinner" style='height:20px'></div></td></tr>
            </tbody>
        </table>
      </div>
    </div>
</div>


<script type='text/javascript'>
$(document).ready(function(){
  $('#spinner').spin('list');

  $.get("{{ URL::to('/buildings/streamall') }}", '', function(data){
    if (data.status){
        for (var f of data.data){
            var content = "<tr>\
<td class='col-xs-1'>"+f.building+"</td>\
<td class='col-xs-1'>"+f.room+"</td>\
<td class='col-xs-2'>"+f.name+"</td>\
<td class='col-xs-2'>"+f.model+"</td>\
<td class='col-xs-1'>"+f.install_date+"</td>\
<td class='col-xs-2'>"+f.maintenance_date+"</td>\
<td class='col-xs-2'>"+f.notes+"</td>\
<td class='col-xs-1'><button type='button' class='btn btn-xs btn-danger' \
onClick='fconf(\"Delete Fumehood\", \""+f.name+"\", \"{{URL::to("admin/fumehoods/remove/")}}/"+f.id+"\")'>Delete</button></td>\
</tr>";
            $('#insert').before(content);
        }
    }

    $('#spinner').spin(false).hide();
    $('#insert').hide();
  });
});

    function conf(title, name, url){
        $('#confirm-title').text(title);       
        $('#confirm-name').text(name);       
        $('#confirm-btn').attr('href', url);       
        $('#confirm-modal').modal('show');       
    }

    function fconf(title, name, url){
        $('#fumehood-name').text(name);       
        $('#fumehood-btn').attr('href', url);       
        $('#fumehood-modal').modal('show');       
    }

@if (Session::has('err'))
  $(document).ready(function(){
    @if (Session::get('err') == 'add')
      $('#{{Session::get('mode')}}-modal').modal('show');       
      $('#{{Session::get('mode')}}-{{Session::get('err')}}-alert').text('{{Session::get('msg')}}').delay(500).slideDown();
      $('#{{Session::get('mode')}}-form input[name="{{Session::get('el')}}"]').parent('div').addClass('has-error');
    @elseif (Session::get('err') == 'edit')
      var parentDiv = $('#{{Session::get('mode')}}-table tbody');
      var innerEl = parentDiv.find('input[value="{{Input::old('id')}}"]').parents('tr');
      parentDiv.scrollTop(innerEl.index() * 45);
      innerEl.find('input[name="{{Session::get('el')}}"]').parent('div').addClass('has-error');
    @endif
  });
@endif
</script>

<div class="modal fade" tabindex="-1" id="confirm-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Really <span id='confirm-title'></span>?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <span id='confirm-name'></span>? All associated fumehoods and their data will also be deleted. This action is irreversible.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="#" id="confirm-btn">Delete</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="fumehood-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Really Delete Fumehood?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <span id='fumehood-name'></span>? All associated data will also be deleted. This action is irreversible.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="#" id="fumehood-btn">Delete</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="building-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Add New Building</h4>
      </div>
      <div class="modal-body">
        <div class='alert alert-danger' style='display:none' id='building-add-alert'></div>
        {{Form::open(array('url' => 'admin/buildings/add', 'id' => 'building-form'))}}
        <div class='form-group'>
          <label>Full Name</label>
          <input type='text' class='form-control' name='name' placeholder='Ex. "AN Bourns Science Building"' 
                value="{{(Session::has('err') && Session::get('err') == 'add' && Session::get('mode') == 'building') ? Input::old('name') : ''}}">
        </div> 
        <div class='form-group'>
          <label>Abbreviation</label>
          <input type='text' class='form-control' name='abbv' placeholder='Ex. "ABB"'
                value="{{(Session::has('err') && Session::get('err') == 'add' && Session::get('mode') == 'building') ? Input::old('abbv') : ''}}">
        </div> 
        {{Form::close()}}
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onClick='$("#building-form").submit()'>Add Building</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="room-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Add New Room</h4>
      </div>
      <div class="modal-body">
        <div class='alert alert-danger' style='display:none' id='room-add-alert'></div>
        {{Form::open(array('url' => 'admin/rooms/add', 'id' => 'room-form'))}}
        <div class='form-group'>
          <label>Building</label>
          {{Form::select('building_id', $bld_sel, (Session::has('err') && Session::get('err') == 'add' && Session::get('mode') == 'room') ? Input::old('building_id') : '', array('class' => 'form-control'))}}
        </div> 
        <div class='form-group'>
          <label>Room Name</label>
          <input type='text' class='form-control' name='name' placeholder='Ex. "201" or "B105"'
                value="{{(Session::has('err') && Session::get('err') == 'add' && Session::get('mode') == 'room') ? Input::old('name') : ''}}">
        </div> 
        {{Form::close()}}
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onClick='$("#room-form").submit()'>Add Room</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
