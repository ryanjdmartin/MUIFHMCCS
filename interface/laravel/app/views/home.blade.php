@extends('home-layout')

@section('main-view')


  <div id="notifications">
  </div>
   

    <div id="ajaxTest">
    </div>
    	

	  <script type="text/javascript">
	    $(document).ready(function(){
	      $('#ajaxTest').load("{{ URL::to('/buildings') }}");
	      $('#notifications').load("{{ URL::to('/notifications') }}");
	    });
	  </script>  	
  


  
@endsection
