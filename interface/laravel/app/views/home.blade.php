@extends('home-layout')

@section('main-view')
  <div id="notifications">
  </div>    	

  <div id="mainInfo">
  </div>

	  <script type="text/javascript">
	    $(document).ready(function(){
	    	if(isMobile()){
	    		$('#mainInfo').load("{{URL::to('/setToMobile')}}");
		      $('#notifications').load("{{ URL::to('/notifications') }}");	
	    	}
	    	else{
				alert(isMobile());
		      $('#mainInfo').load("{{ URL::to('/buildings') }}");
		      $('#notifications').load("{{ URL::to('/notifications') }}");	
	    	}

	    });
	  </script>  	
  
@endsection
