@extends('home-layout')

@section('main-view')
  <div id="notifications">
  </div>    	

  <div id="mainInfo">
  </div>

	  <script type="text/javascript">
	    $(document).ready(function(){
	    	if(isMobile()){
	    	  var url = "{{ URL::to('/toggleview/0') }}";
	          $.post(url, '', function(data){
	            //alert("Success!");
	    	    $('#mainInfo').load("{{ URL::to('/buildings') }}");
				$('#notifications').load("{{ URL::to('/notifications') }}");
	          });
	    	}
	    	else{
		      $('#mainInfo').load("{{ URL::to('/buildings') }}");
		      $('#notifications').load("{{ URL::to('/notifications') }}");	
	    	}

	    });
	  </script>  	
  
@endsection
