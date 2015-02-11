@extends('layout')

@section('content')
<style>
#add-user{
  white-space: nowrap;
  position: absolute;
  display: none;
  width: 35%;
  left: 0px;
  padding-bottom: 15px;
}
#add-user div.alert{
  white-space: normal;
}
#user-list{
  position: absolute;
  right: 0px;
  width: 100%;
  padding-bottom: 15px;
}

#chev{
  float: left;
  padding-top: 2px;
  padding-right: 5px;
}
</style>

      <div class="row">
        <div class="col-md-12 main">
          <h1 class="page-header">Manage Users</h1>

	<div class='row'>
	  <div class='col-md-12' style='padding-bottom: 5px'>
	    <button class='btn btn-primary' id='toggle-add-user'><span id='chev' class='glyphicon glyphicon-chevron-right'></span>Add New User </button>
	     <span id='msg' style='display:none' class='alert alert-small pull-right'></span>
	  </div>
	</div>
	 <div class="row">
	  <div class='col-md-12'>
	    <div class='col-md-4' id='add-user'>
	      <div class='panel panel-primary'>
		<div class='panel-body'>
		  <div id='user-msg' style='display:none' class='alert'></div>
		  {{ Form:: open() }}
		    <input type='hidden' name='do_add_user' value='True'>
		    <div class='form-group'>
		      <label for='email'>Email:</label>
		      <input class='form-control' name='email' id='email' type='email'>
		      <p class='help-block'>Must be a valid email. A randomized <br>
			  password will be emailed to the new user.</p>
		    </div>
		    <div class='form-group'>
              {{}}
		    </div>
		    <div style='text-align: right'>
		      <button onClick='$(this).button("loading");' class='btn btn-success' data-loading-text='Please Wait...'>Create User</button>
		    </div>
		  {{ Form:: close() }}
		</div>
	      </div>
	    </div>
	    <div class='col-md-8' id='user-list'>
	      <table class='table table-bordered table-striped table-hover'>
		<thead>
		 <tr>
		  <th>Username</th>
		  <th>Email</th>
		  <th>Permissions</th>
		  <th>Actions</th>
		 </tr>
		</thead>
		<tbody>
<? 
	$query = 'SELECT id, username, email FROM users ORDER BY username';
	$result = $mysqli->query($query);
	while ($row = $result->fetch_assoc()){
		$query = 'SELECT id,fullname FROM user_perms
			INNER JOIN permissions ON permissions.id = perm_id
			WHERE user_id = '.$row['id'].'
			ORDER BY permissions.id';
		echo "<tr>
			<td>".htmlspecialchars($row['username'])."</td>
			<td>".htmlspecialchars($row['email'])."</td>
			<td><ul style='padding-left: 20px'>";

		$perms = $mysqli->query($query);
		while ($permrow = $perms->fetch_row()){
			echo "<li name='$permrow[0]'>$permrow[1]</li>";
		}

		echo "</ul>
			</td>
			<td>";
		if ($row['username'] == $_SESSION['username'] || $row['username'] == 'admin'){
			echo "No Actions Available.";
		} else{
			echo "<div class='btn-group btn-group-xs'>
			    <button class='btn btn-primary' onClick='openEdit(this,".$row['id'].");'>Edit</button>
			    <button class='btn btn-primary' onClick='openDelete(this,".$row['id'].");'>Delete</button>
			    </div>";
		}
		echo "</td>
		      </tr>";
	}
?>	
		</tbody>
	      </table>
	    </div>

         </div>
         </div>
        </div>
      </div>

<script type='text/javascript'>
var open = false;
oldButton = $('#toggle-add-user').css('width');

$('#toggle-add-user').click(toggleAdd);
function toggleAdd(){
  open = !open;
  $('#user-list').animate({'width': open ? '65%' : '100%'});
  $(this).animate({'width': open ? $('#add-user').width() : oldButton});
  $('#chev').removeClass('glyphicon-chevron-left glyphicon-chevron-right').addClass(
	  open ? 'glyphicon-chevron-left' : 'glyphicon-chevron-right');
  $('#add-user').animate({'width': 'toggle'});
}

<? if (isset($_POST['do_add_user'])){
	echo "$(document).ready(function(){
	  open = !open;
	  $('#user-list').css({'width': '65%'});
	  $('#add-user').show();
	  $('#toggle-add-user').css({'width': $('#add-user').width()});
	  $('#chev').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');";
	if ($user_msg){
		echo "$('#user-msg').addClass('alert-success').html('".addslashes($user_msg)."').delay(300).slideDown();";
	} else if ($user_err) {
		echo "$('#user-msg').addClass('alert-danger').html('".addslashes($user_err)."').delay(300).slideDown();";
	}
	echo "});";
}

if ($success_msg){
	echo "$('#msg').addClass('alert-success').html('".addslashes($success_msg)."').delay(300).fadeIn();";
} else if ($error_msg) {
	echo "$('#msg').addClass('alert-danger').html('".addslashes($error_msg)."').delay(300).fadeIn();";
}?>

function openEdit(btn, id){
	var row = $(btn).parents('tr');
	var username = row.children('td:nth-child(1)').html();
	var email = row.children('td:nth-child(2)').text();
	$('#edit_user_id').val(id);
	$('#edit_user_name').html(username);
	$('#edit_user_email').val(email);

	row.children('td:nth-child(3)').find('li').each(function(){
		$('#edit-form').find("input[type='checkbox'][value='"+
			$(this).attr('name')+"']").prop('checked',true);
	});

	$('#edit-modal').modal('show')
}

function openDelete(btn, id){
	var row = $(btn).parents('tr');
	var username = row.children('td:nth-child(1)').html();
	$('#delete_user_id').val(id);
	$('#delete_user_name').html(username);
	$('#delete-modal').modal('show')
}
</script>

    <div class="modal fade" id='edit-modal'>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Editing User: <span id='edit_user_name'></span></h4>
          </div>
	  <div class="modal-body">
	    <form id='edit-form' method='POST'>
	      <input type='hidden' name='do_edit_user' value='True'>
	      <input type='hidden' name='user_id' id='edit_user_id' value=''>
	      <div class='form-group'>
		<label for='edit_user_email'>Email:</label>
		<input class='form-control' name='email' id='edit_user_email' type='text'>
	      </div>
	      <div class='form-group'>
		<label for='permissions[]'>Permissions:</label>	
		<? $query = 'SELECT * FROM permissions
			ORDER BY id';
		$result = $mysqli->query($query);
		while ($row = $result->fetch_assoc()){
			echo "<div class='checkbox'>
			  <label>
			  <input type='checkbox' name='permissions[]' value=".$row['id']."> ".$row['fullname']."
    			  </label>
			</div>";
		}
		?>
	      </div>
	    </form>
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
	    <form id='delete-form' method='POST'>
	      <input type='hidden' name='do_delete_user' value='True'>
	      <input type='hidden' name='user_id' id='delete_user_id' value=''>
	      <p>Are you sure you want to delete <span id='delete_user_name'></span>?</p>
	    </form>
          </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onClick='$("#delete-form").submit();'>Delete User</button>
	  </div>
        </div>
      </div>
    </div>
@endsection
