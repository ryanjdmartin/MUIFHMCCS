@extends('home-layout')

@section('main-view')
  <div id="notifications">
  </div>    	

  <div id="mainInfo">
  </div>

	  <script type="text/javascript">
	    $(document).ready(function(){
	      $('#mainInfo').load("{{ URL::to('/buildings') }}");
	      $('#notifications').load("{{ URL::to('/notifications') }}");
	    });
	  </script>  	
  
@endsection
