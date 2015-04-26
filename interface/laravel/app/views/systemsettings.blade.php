
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
	
	
@endsection
