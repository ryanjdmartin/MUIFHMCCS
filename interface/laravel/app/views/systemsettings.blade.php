
@extends('layout')

@section('content')

<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Manage System Settings</h1>

	 <div class="row">
	    <div class='col-md-8' id='system-settings-list'>
	      <table class='table table-bordered table-striped table-hover'>
		<thead>
		{{ Form::open(array('url' => route('systemsettings.edit'), 'id' => 'edit-form')) }}
		<tr>
			<th>Setting</th>
			<th>Value</th>
			<th>New Values <div class='pull-right'>{{ Form::submit('Update') }}</div></th>
		</tr>
		</thead>
		<tbody>
        @foreach ($settings_list as $setting)
		  <tr>
			<td>{{ $setting["name"] }}</td>
			<td>{{ $system_settings->$setting["db_ident"]." ".$setting["units"] }}</td>
		    <td>{{ Form::text($setting["db_ident"], $system_settings->$setting["db_ident"]) }}</td>
		 </tr>
        @endforeach
		{{ Form::close() }}
		</tbody>
	  </table>
	</div>

  </div>
</div>
</div>
</div>


    <div class="modal fade" id='edit-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Editing Setting: <span id='edit_user_name'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('systemsettings.edit'), 'id' => 'edit-form')) }}
	      <input type='hidden' name='id' id='edit_id' value=''>
	      <div class='form-group'>
		<label for='edit_email'>Email:</label>
		<input class='form-control' name='email' id='edit_email' type='email'>
	      </div>
        {{ Form::close() }}
          </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onClick='$("#edit-form").submit();'>Submit</button>
	  </div>
        </div>
      </div>
    </div>
	
	
@endsection
