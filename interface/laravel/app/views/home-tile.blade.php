@extends('home-layout')

@section('main-view') 	
	
	<form id = "login_form" method="POST" action="{{ URL::to('/test') }}">
	<button class = "btn" type="button" id="sign_in" >Sign in</button>
	</form>
	<div id = "ajaxTest">test</div>
	<script type = 'text/javascript'>
		$(document).ready(function(){
			$('#sign_in').on('click', function(){
				//alert('We click');
				var login_form = $('#login_form').serializeArray();
				var url = $('#login_form').attr('action');
				//alert(url);
				$.post(url, login_form, function(data){
					alert(data);
					$('#ajaxTest').html(data);
				});
			});
		});
	</script>
  @for ($i=1; $i < rand(15,30); $i++)
  	<div class="btn-group btn-group-vertical">
  		<button class="btn btn-primary btn-lg" style="width: 200px; height:100px; margin-bottom: 0px;" onclick="ajax_test();">Building {{ $i }}</button>
  		<button class="btn btn-info btn-lg" style="width: 200px; height:50px; margin-bottom: 20px;">FumeHood Alerts</button>
  	</div>
    
  @endfor
@endsection
