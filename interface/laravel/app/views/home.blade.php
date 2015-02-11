@extends('home-layout')

@section('main-view')
  <div id="tile-view" style="display:none">

  </div>
	<div id = "ajaxTest">test</div>
	<div id = "ajaxTest2"></div>
  <!--
  	<form id = "login_form" method="POST" action="{{ URL::to('/test') }}">
	<button class = "btn" type="button" id="sign_in" >Sign in</button>
	</form>

	<script type = 'text/javascript'>
		$(document).ready(function(){
			$('#sign_in').on('click', function(){
				//alert('We click');
				var login_form = $('#login_form').serializeArray();
				var url = $('#login_form').attr('action');
				//alert(url);
				$.get(url, login_form, function(data){
					alert(data);
					$('#ajaxTest').html(data);
				});
			});
		});
	-->
	</script>

	<script type = 'text/javascript'>
		$('#ajaxTest').load("{{ URL::to('/buildings') }}");
	</script>
	<!--
	<script type = 'text/javascript'>
		$('#ajaxTest2').load("{{ URL::to('/rooms/1') }}");
	</script>-->
  <table id="list-view" style="display:none;" class="table table-striped table-hover">
  </table>
<!-- Commented out for now
  <script type="text/javascript">
  $(document).ready(function(){
    tileView();
  });
  </script>
-->
@endsection
