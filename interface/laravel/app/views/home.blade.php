@extends('home-layout')

@section('main-view')
  <div id="notifications">
  </div>    	

  <div id="mainInfo">
  </div>

	  <script type="text/javascript">
	    $(document).ready(function(){
	    	if(isMobile()){
	    		load("{{URL::to('/setToMobile')}}");

	    	}
			alert(isMobile());
	      $('#mainInfo').load("{{ URL::to('/buildings') }}");
	      $('#notifications').load("{{ URL::to('/notifications') }}");
	    });
	  </script>  	
  
@endsection
