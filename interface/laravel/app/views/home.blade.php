@extends('home-layout')

@section('main-view')
    <div id="mainInfo">
    </div>

  <div id="notifications">
  </div>    	

	  <script type="text/javascript">
	    $(document).ready(function(){
	      $('#mainInfo').load("{{ URL::to('/buildings') }}");
	      $('#notifications').load("{{ URL::to('/notifications') }}");
	    });
	  </script>  	
  
@endsection
