
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
			    <button class='btn btn-primary' onClick='openEdit(this,{{ Auth::user()->id }});'>Edit</button></div> </th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	  </table>
	</div>

  </div>
</div>
</div>
</div>

<script type='text/javascript'>

function openEdit(btn, id){
	var email = '{{ Auth::user()->email }}';
	$('#edit_id').val(id);
	$('#edit_email').val(email);

	$('#edit-modal').modal('show')
}

@if (Session::has('err'))
  $(document).ready(function(){
  @if (Session::get('err') == 'add')
    open = !open;
    $('#user-list').css({'width': '65%'});
    $('#add-user').show();
    $('#toggle-add-user').css({'width': $('#add-user').width()});
    $('#chev').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');;
    
    $('#email').val('{{ Session::get('email') }}');
    $('#email').parent('div').addClass('has-error');
	$('#user_type').val({{ Session::get('user_type') }});
  @else
    $('#edit-modal').modal('show');

    $('#edit_id').val('{{ Session::get('id') }}');
    $('#edit_email').val('{{ Session::get('email') }}');
    $('#email').parent('div').addClass('has-error');
	$('#edit_user_type').val({{ Session::get('user_type') }});
  @endif
  });
@endif

</script>

    <div class="modal fade" id='edit-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Update Email Address: <span id='edit_user_name'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('user.email'), 'id' => 'edit-form')) }}
	      <input type='hidden' name='id' id='edit_id' value=''>
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
	    <button type="button" class="btn btn-primary" onClick='$("#edit-form").submit();'>Submit</button>
	  </div>
        </div>
      </div>
    </div>

@endsection




