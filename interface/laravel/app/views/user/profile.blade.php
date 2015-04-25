
@extends('layout')

@section('content')

<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Profile Settings</h1>

	 <div class="row">
	    <div class='col-md-8' id='system-settings-list'>
	      <table class='table table-bordered table-striped table-hover'>
		<thead>
		
		<tr>
			<th>Current Email: </th>
			<th>{{ Auth::user()->email }} <div class='btn-group btn-group-xs'>
			    <button class='btn btn-primary' onClick='updateEmail({{ Auth::user()->id }});'>Edit</button> <button class='btn btn-primary' onClick='updatePassword({{ Auth::user()->id }});'>Update Password</button></div> </th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	  </table>
	</div>
  </div>
  
  
  <div class="container">
  <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#settings">Edit Notification Settings</button>
  <div id="settings" class="collapse">
	{{ Form::open(array('url' => route('user.notificationsettings'), 'id' => 'notification-form')) }}

		{{ Form::hidden('notification_id', Auth::user()->id ) }}
		
		@foreach (Building::all() as $building)
			<div><strong>{{ $building->name }}</strong></div>
			@foreach($building->getRooms() as $room)
				<div>{{ $building->abbv.' '.$room->name }} Critical: {{ Form::checkbox($room->id.'_critical', $room->id.'_critical', array_get($notification_settings, $room->id.'.critical', '0')) }} Alert: {{ Form::checkbox($room->id.'_alert', $room->id.'_alert', array_get($notification_settings, $room->id.'.alert', '0')) }}</div>
			@endforeach
		@endforeach
	<!-- {{ Form::checkbox('box_input', 'box_name') }} -->

	{{ Form::submit('Update Notification Settings') }}
	{{ Form::close() }}
  </div>
</div>

</div>
</div>



<script type='text/javascript'>

function updateEmail(id){
	var email = '{{ Auth::user()->email }}';
	$('#email_id').val(id);
	$('#edit_email').val(email);

	$('#email-modal').modal('show')
}

function updatePassword(id){
	$('#password_id').val(id);

	$('#password-modal').modal('show')
}

@if (Session::has('err'))
  $(document).ready(function(){
  @if (Session::get('err') == 'password')
    $('#password-modal').modal('show');
  @elseif (Session::get('err') == 'email')
    $('#email-modal').modal('show');

    $('#edit_id').val('{{ Session::get('id') }}');
    $('#edit_email').val('{{ Session::get('email') }}');
    $('#email').parent('div').addClass('has-error');
   @else
	//Do nothing.

  @endif
  });
@endif

</script>

    <div class="modal fade" id='email-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Update Email Address: <span id='edit_user_name'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('user.email'), 'id' => 'email-form')) }}
	      <input type='hidden' name='id' id='email_id' value=''>
	      <div class='form-group'>
		<label for='edit_email'>Email:</label>
		<input class='form-control' name='email' id='edit_email' type='email'>
	      </div>
	      <div class='form-group'>
		<label for='current_password'>Current Password:</label>
		<input class='form-control' name='password' id='current_password' type='password'>
	      </div>
        {{ Form::close() }}
          </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onClick='$("#email-form").submit();'>Submit</button>
	  </div>
        </div>
      </div>
    </div>
	
	
    <div class="modal fade" id='password-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Update Password: <span id='edit_password'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('user.password'), 'id' => 'edit-password')) }}
	      <input type='hidden' name='id' id='password_id' value=''>
	      <div class='form-group'>
			<label for='new_password'>New Password:</label>
			<input class='form-control' name='new_password' id='new_password' type='password'>
	      </div>
		  <div class='form-group'>
			<label for='new_password_confirm'>Confirm New Password:</label>
			<input class='form-control' name='new_password_confirm' id='new_password_confirm' type='password'>
	      </div>
	      <div class='form-group'>
			<label for='old_password_confirm'>Current Password:</label>
			<input class='form-control' name='old_password_confirm' id='old_password_confirm' type='password'>
	      </div>
        {{ Form::close() }}
          </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onClick='$("#edit-password").submit();'>Submit</button>
	  </div>
        </div>
      </div>
    </div>

@endsection




