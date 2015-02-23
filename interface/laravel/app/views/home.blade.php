@extends('home-layout')

@section('main-view')
    <div id="ajaxTest">
    </div>

	  <script type="text/javascript">
	    $(document).ready(function(){
	      $('#ajaxTest').load("{{ URL::to('/buildings') }}");
	    });
	  </script>  	
@endsection
