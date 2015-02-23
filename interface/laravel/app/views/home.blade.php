@extends('home-layout')

@section('main-view')
	<?php 
		Session::forget('breadcrumbs');
		Session::push('breadcrumbs', ['Buildings', '/buildings/']); 
		Session::push('breadcrumbs', ['index2', 'test2']);

	?>
    <div id="mainInfo">
    </div>

	<script type="text/javascript">
		$(document).ready(function(){
		  $('#mainInfo').load("{{ URL::to('/buildings') }}");
		});
	</script>  	
@endsection
