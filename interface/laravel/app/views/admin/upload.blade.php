@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Uploading Fumehood CSV: {{$building->name}} ({{$building->abbv}})
    </h1>
    <div class='alert alert-info'>
        <p>Select which data to update in the database. Each section can be saved independently, or ignored altogether. Press "Done" at the bottom when finished.
        <p><b>Note: Fumehoods with unknown rooms will have rooms automatically created.</b><p>
        <ul>
          <li>Add New Fumehoods: Fumehoods within the uploaded file that do not appear in the database will be added to the database. If unchecked, new fumehoods will be ignored.</li>
          <li>Update Existing Fumehoods: Data within the uploaded file will overwrite existing hoods in the database. If unchecked, existing fumehoods will not be altered even if they appear in the CSV.</li>
        </ul>
    </div>
  </div>
</div>
    
<div class="row">
    <div class="col-md-12">
        <div class='panel panel-info'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Add Fumehoods in {{$building->abbv}}
              @if ($add)
                        <button class='btn btn-primary btn-sm pull-right' style='margin-top: -6px' data-toggle='modal' data-target='#add-modal' data-loading-text='Adding...' id='add-btn' type='button'>Add All</button>
              @endif
            </h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='building-table'>
            <thead>
                <tr>
                    <th class='col-xs-2 filterable'>
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
            <tbody id='add-table'>
            @foreach ($add as $f)
                <tr>
                    <form>
                    <input type='hidden' name='building_id' value='{{$building->id}}'>
                    <td class='col-xs-2'>
                        {{$building->abbv}} {{$f['room']}} 
                        @if ($f['room_id'] == 0)
                            <span class='badge' name='{{$f['room']}}'>NEW</span>
                        @endif
                        <input type='hidden' name='room' value='{{$f['room']}}'>
                        <input type='hidden' name='room_id' value='{{$f['room_id']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['name']}}
                        <input type='hidden' name='name' value='{{$f['name']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['model']}}
                        <input type='hidden' name='model' value='{{$f['model']}}'>
                    </td>
                    <td class='col-xs-1'>
                        {{$f['install_date']}}
                        <input type='hidden' name='install_date' value='{{$f['install_date']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['maintenance_date']}}
                        <input type='hidden' name='maintenance_date' value='{{$f['maintenance_date']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['notes']}}
                        <input type='hidden' name='notes' value='{{$f['notes']}}'>
                    </td>
                    <td class='col-xs-1'>
                        <button type='button' class='btn btn-primary btn-xs' onClick='doSub(this, "{{URL::to('admin/upload/add')}}");' data-loading-text='Please Wait...'>Add</button>
                    </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class='panel panel-success'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Update Fumehoods in {{$building->abbv}}
              @if ($update)
                        <button class='btn btn-success btn-sm pull-right' style='margin-top: -6px' data-toggle='modal' data-target='#update-modal' data-loading-text='Updating...' id='update-btn' type='button'>Update All</button>
              @endif
            </h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='building-table'>
            <thead>
                <tr>
                    <th class='col-xs-2 filterable'>
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
            <tbody id='update-table'>
            @foreach ($update as $f)
                <tr>
                    <form>
                    <td class='col-xs-2'>
                        <input type='hidden' name='building_id' value='{{$building->id}}'>
                        {{$building->abbv}} {{$f['room']}} 
                        @if ($f['room_id'] == 0)
                            <span class='badge' name='{{$f['room']}}'>NEW</span>
                        @endif
                        <input type='hidden' name='room' value='{{$f['room']}}'>
                        <input type='hidden' name='room_id' value='{{$f['room_id']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['name']}}
                        <input type='hidden' name='name' value='{{$f['name']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['model']}}
                        <input type='hidden' name='model' value='{{$f['model']}}'>
                    </td>
                    <td class='col-xs-1'>
                        {{$f['install_date']}}
                        <input type='hidden' name='install_date' value='{{$f['install_date']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['maintenance_date']}}
                        <input type='hidden' name='maintenance_date' value='{{$f['maintenance_date']}}'>
                    </td>
                    <td class='col-xs-2'>
                        {{$f['notes']}}
                        <input type='hidden' name='notes' value='{{$f['notes']}}'>
                    </td>
                    <td class='col-xs-1'>
                        <button type='button' class='btn btn-success btn-xs' onClick='doSub(this, "{{URL::to('admin/upload/update')}}");' data-loading-text='Please Wait...'>Add</button>
                    </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>

<div class='row'>
    <div class='col-md-12'>
        <div class='pull-right'>
            <a class='btn btn-primary' href='{{route("admin.hoods")}}'>Done</a>
            <br><br>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="add-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Add All Fumehoods?</h4>
      </div>
      <div class="modal-body">
        <p>Add all these fumehoods? Rooms will be created where necessary.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick='subAll("add", "{{URL::to('admin/upload/add')}}")'>Add All</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="update-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Update All Fumehoods?</h4>
      </div>
      <div class="modal-body">
        <p>Update all these fumehoods? Rooms will be created where necessary.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick='subAll("update", "{{URL::to('admin/upload/update')}}")'>Update All</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type='text/javascript'>

function doSub(btn, url, parent, callback){
  if (parent){
    btn = $(parent).first();
  }

  $(btn).button('loading');
  var row = $(btn).parents('tr');

  var form = row.children('form').serialize();

  var j = $.post(url, form, function(data){
    if (data.status){
      if (data.room){
        $('span[name="'+data.room+'"]').fadeOut(function(){ this.remove() }); 
        $('input[value="'+data.room+'"]').each(function(){
            $(this).siblings('input[name="room_id"]').val(data.room_id);
        });
      }
      row.delay(500).slideUp(function(){ 
        this.remove(); 
        if (parent){
            if (!$(parent).length){
                callback();
            } else {
                doSub(false, url, parent, callback);
            }
        }
      });   
    } else {
      $(btn).button('reset');
    }
  }).fail(function() {
    $(btn).button('reset');
    alert("An error occured.");
    if (parent){
        $(parent).button('reset');
    }
  });
}

function subAll(tbl, url){
    $('#'+tbl+'-btn').button('loading');
    $('#'+tbl+'-modal').modal('hide');

    $('#'+tbl+'-table button').button('loading');

    doSub(false, url, '#'+tbl+'-table button', function() {
        setTimeout(function() { $('#'+tbl+'-btn').text('Complete'); }, 500);
    });
}
</script>
@endsection
