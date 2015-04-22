
@extends('layout')

@section('content')

<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Manage System Settings</h1>

	 <div class="row">
	    <div class='col-md-8' id='system_settings-list'>
	      <table class='table table-bordered table-striped table-hover'>
		<thead>
		 <tr>
		  <th>Critical Max Velocity</th>
		  <th>Critical Min Velocity</th>
		  <th>Alert Max Velocity</th>
		  <th>Actions</th>
		 </tr>
		</thead>
		<tbody>
        @foreach ($system_settings as $settings_row)
		  <tr>
			<td>{{ $settings_row->critical_max_velocity }}</td>
			<td>{{ $settings_row->critical_min_velocity }}</td>
			<td>{{ $user_types[2] }}</td>
		    <td><div class='btn-group btn-group-xs'>
			    <button class='btn btn-primary' onClick='openEdit(this,{{ $settings_row->id }});'>Edit</button>
			  </div>
		   </td>
		 </tr>
        @endforeach
		</tbody>
	  </table>
	</div>

  </div>
</div>
</div>
</div>

<script type='text/javascript'>


function openEdit(btn, id){
	var row = $(btn).parents('tr');
	var email = row.children('td:nth-child(1)').html();
	var system_settings_type = row.children('td:nth-child(2)').text();
	$('#edit_id').val(id);
	$('#edit_email').val(email);

	$('#edit_system_settings_type:selected').removeAttr('selected');
	$('#edit_system_settings_type option').filter(function(){
        return ($(this).text() == system_settings_type);
    }).prop('selected', true);

	$('#edit-modal').modal('show')
}


@if (Session::has('err'))
  $(document).ready(function(){
  @if (Session::get('err') == 'add')
    open = !open;
    $('#system_settings-list').css({'width': '65%'});
    $('#add-system_settings').show();
    $('#toggle-add-system_settings').css({'width': $('#add-system_settings').width()});
    $('#chev').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');;
    
    $('#email').val('{{ Session::get('email') }}');
    $('#email').parent('div').addClass('has-error');
	$('#system_settings_type').val({{ Session::get('system_settings_type') }});
  @else
    $('#edit-modal').modal('show');

    $('#edit_id').val('{{ Session::get('id') }}');
    $('#edit_email').val('{{ Session::get('email') }}');
    $('#email').parent('div').addClass('has-error');
	$('#edit_system_settings_type').val({{ Session::get('system_settings_type') }});
  @endif
  });
@endif

</script>

    <div class="modal fade" id='edit-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Editing System Setting: <span id='edit_system_settings_name'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('users.edit'), 'id' => 'edit-form')) }}
	      <input type='hidden' name='id' id='edit_id' value=''>
	      <div class='form-group'>
		<label for='edit_email'>Email:</label>
		<input class='form-control' name='email' id='edit_email' type='email'>
	      </div>
	      <div class='form-group'>
             {{ Form::select('system_settings_type', $user_types, '', array('class' => 'form-control', 'id' => 'edit_system_settings_type')) }}
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
