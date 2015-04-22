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
    <div class="col-md-8">
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Manage Buildings <button class='pull-right btn btn-success btn-xs' data-toggle='modal' data-target='#building-modal'>Add New Building</button></h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table'>
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
                    {{Form::hidden('id', $b->id)}}
                    <td class='col-xs-7'>
                        {{Form::text('name', $b->name, array('style' => 'width: 100%'))}}
                    </td>
                    <td class='col-xs-2'>
                        {{Form::text('abbv', $b->abbv, array('style' => 'width: 100%'))}}
                    </td>
                    <td class='col-xs-3'>
                        <button type='submit' class='btn btn-xs btn-success'>Save</button>
                        <button type='button' class='btn btn-xs btn-danger' onClick='conf("Delete Building", "{{$b->name}}", "{{URL::to("admin/buildings/remove/".$b->id)}}")'>Delete</button>
                    </td>
                    {{Form::close()}}
                <tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Manage Rooms <button class='pull-right btn btn-success btn-xs' data-toggle='modal' data-target='#room-modal'>Add New Room</button></h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table'>
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

<script type='text/javascript'>
    function conf(title, name, url){
        $('#confirm-title').text(title);       
        $('#confirm-name').text(name);       
        $('#confirm-btn').attr('href', url);       
        $('#confirm-modal').modal('show');       
    }
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

<div class="modal fade" tabindex="-1" id="building-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title">Add New Building</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('url' => 'admin/buildings/add', 'id' => 'building-form'))}}
        <div class='form-group'>
          <label>Full Name</label>
          <input type='text' class='form-control' name='name' placeholder='Ex. "AN Bourns Science Building"'>
        </div> 
        <div class='form-group'>
          <label>Abbreviation</label>
          <input type='text' class='form-control' name='abbv' placeholder='Ex. "ABB"'>
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
        {{Form::open(array('url' => 'admin/rooms/add', 'id' => 'room-form'))}}
        <div class='form-group'>
          <label>Building</label>
          {{Form::select('building_id', $bld_sel, '', array('class' => 'form-control'))}}
        </div> 
        <div class='form-group'>
          <label>Room Name</label>
          <input type='text' class='form-control' name='name' placeholder='Ex. "201" or "B105"'>
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

<div class="row">
  <div class="col-md-12">
    <div class='panel panel-primary'>
      <div class='panel-heading'>
        <h4 class='panel-title'>Upload/Download Fumehoods</h4>
      </div>
      <div class='panel-body'>
        <div class='alert alert-info'>
            <p>Here you can upload or download the CSV of fumehoods. Currently, this is the only way to populate the database with fumehood information.
            </p>
            <p>When you upload a CSV, you will first be presented with a summary screen displaying possible changes to be made. This summary screen may take a while to load depending on the number of fumehoods involved. Once the summary screen appears, you can choose what changes are to be made.
            </p>
            <p>The CSV must contain headings. These headings determine the data to be entered. If a heading is missing, it is ignored and the data is assumed to be empty. 
            <br>Suitable headings are the following (must be exact):
            <table class='table table-condensed'><tr>
                <th>name</th>
                <th>room_name</th>
                <th>model</th>
                <th>install_date</th>
                <th>maintenance_date</th>
                <th>notes</th>
            </tr></table>
            All dates must be in the format YYYY-MM-DD HH:MM:SS
            </p>        
            <p>Downloading the CSV will give you a compatible file, and is a good way to see how the information should be arranged.</p>        
        </div>
        
    <div class='row'>
      <div class='col-md-6'>
        <div class='panel panel-default' style='text-align: center'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Upload Fumehoods</h4>
          </div>
          <div class='panel-body'>
            {{Form::open(array('url' => 'admin/upload', 'class' => 'form-horizontal'))}}
            <div class="form-group">
              <label class='col-sm-3 control-label'>Select CSV File: </label>
              <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <span class="btn btn-primary btn-file">
                    Browse&hellip; <input type='file' name='csv'>
                  </span>
                </span>
                <input type="text" class="form-control" readonly>
              </div>
              </div>
              <div class="col-sm-2">
                <button type='submit' class='btn btn-success' onClick='$(this).button("loading");' data-loading-text='Wait...'>Upload CSV</button>
              </div>
            </div>
            {{Form::close()}}
          </div>        
        </div>        
      </div>
      <div class='col-md-6'>
<<<<<<< HEAD
        <div class='panel panel-default' style='text-align: center'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Download Fumehoods</h4>
          </div>
          <div class='panel-body'>
            <a class='btn btn-primary' href='{{route("admin.download")}}'>Download Fumehood CSV</a>
=======
        <div class='panel panel-default'>
          <div class='panel-heading' style='text-align:center'>
            <h4 class='panel-title'>Download Fumehoods</h4>
          </div>
          <div class='panel-body'>
            {{Form::open(array('url' => 'admin/download', 'class' => 'form-horizontal'))}}
            <div class='form-group'>
              <label class="col-sm-3 control-label">Select Building:</label>
              <div class="col-sm-9">      
                  {{Form::select('building_id', $bld_sel, '', array('class' => 'form-control'))}}
              </div>
            </div>
            <div class='form-group'>
              <div class="col-sm-offset-3 col-sm-9">      
                <button type='submit' class='btn btn-primary' href='{{route("admin.download")}}'>Download Fumehood CSV</button>
              </div>
            </div>
            {{Form::close()}}
>>>>>>> ryan
          </div>        
        </div>        
      </div>
    </div>

      </div>
    </div>
  </div>
</div>

@endsection
