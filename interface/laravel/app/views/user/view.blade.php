@extends('layout')

@section('content')

<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Manage Users</h1>

	<div class='row'>
	  <div class='col-md-12' style='padding-bottom: 5px'>
	    <button class='btn btn-primary' id='toggle-add-user' style='width: 135px'><span id='chev' class='glyphicon glyphicon-chevron-right'></span>Add New User </button>
	  </div>
	</div>
	 <div class="row">
	  <div class='col-md-12'>
	    <div class='col-md-4' id='add-user'>
	      <div class='panel panel-primary'>
		<div class='panel-body'>
		  {{ Form::open(array('url' => route('users.add'))) }}
		    <div class='form-group'>
		      <label for='email'>Email:</label>
		      <input class='form-control' name='email' id='email' type='email'>
		      <p class='help-block'>Must be a valid email. A randomized <br>
			  password will be emailed to the new user.</p>
		    </div>
		    <div class='form-group'>
              {{ Form::select('user_type', $user_types, '', array('class' => 'form-control', 'id' => 'user_type')) }}
		    </div>
		    <div style='text-align: right'>
		      <button class='btn btn-success'>Create User</button>
		    </div>
		  {{ Form::close() }}
		</div>
	      </div>
	    </div>
	    <div class='col-md-8' id='user-list'>
	      <table class='table table-bordered table-striped table-hover'>
		<thead>
		 <tr>
		  <th>Email</th>
		  <th>User Type</th>
		  <th>Actions</th>
		 </tr>
		</thead>
		<tbody>
        @foreach ($users as $user)
		  <tr>
			<td>{{ $user->email }}</td>
			<td>{{ $user->userType()->name }}</td>
		    <td>
            @if ($user->id == Auth::user()->id)
              <a href="{{ route('user.profile') }}" class='btn btn-primary btn-xs'>Edit Your Profile</a>
		    @else
			  <div class='btn-group btn-group-xs'>
			    <button class='btn btn-primary' onClick='openEdit(this,{{ $user->id }});'>Edit</button>
			    <button class='btn btn-primary' onClick='openDelete(this,{{ $user->id }});'>Delete</button>
			  </div>
		    @endif
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
var open = false;

$('#toggle-add-user').click(toggleAdd);

function toggleAdd(){
  open = !open;
  $('#user-list').animate({'width': open ? '65%' : '100%'});
  $(this).animate({'width': open ? $('#add-user').width() : '135px'});
  $('#chev').removeClass('glyphicon-chevron-left glyphicon-chevron-right').addClass(
	  open ? 'glyphicon-chevron-left' : 'glyphicon-chevron-right');
  $('#add-user').animate({'width': 'toggle'});
}

function openEdit(btn, id){
	var row = $(btn).parents('tr');
	var email = row.children('td:nth-child(1)').html();
	var user_type = row.children('td:nth-child(2)').text();
	$('#edit_id').val(id);
	$('#edit_email').val(email);

	$('#edit_user_type:selected').removeAttr('selected');
	$('#edit_user_type option').filter(function(){
        return ($(this).text() == user_type);
    }).prop('selected', true);

	$('#edit-modal').modal('show')
}

function openDelete(btn, id){
	var row = $(btn).parents('tr');
	var username = row.children('td:nth-child(1)').html();
	$('#delete_id').val(id);
	$('#delete_user_name').html(username);
	$('#delete-modal').modal('show')
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
	    <h4 class="modal-title">Editing User: <span id='edit_user_name'></span></h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('users.edit'), 'id' => 'edit-form')) }}
	      <input type='hidden' name='id' id='edit_id' value=''>
	      <div class='form-group'>
		<label for='edit_email'>Email:</label>
		<input class='form-control' name='email' id='edit_email' type='email'>
	      </div>
	      <div class='form-group'>
            {{ Form::select('user_type', $user_types, '', array('class' => 'form-control', 'id' => 'edit_user_type')) }}
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

    <div class="modal fade" id='delete-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Delete User</h4>
          </div>
	  <div class="modal-body">
		{{ Form::open(array('url' => route('users.delete'), 'id' => 'delete-form')) }}
	      <input type='hidden' name='id' id='delete_id' value=''>
	      <p>Are you sure you want to delete <span id='delete_user_name'></span>?</p>
        {{ Form::close() }}
          </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onClick='$("#delete-form").submit();'>Delete User</button>
	  </div>
        </div>
      </div>
    </div>
@endsection
