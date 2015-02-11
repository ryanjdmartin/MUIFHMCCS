@extends('home-layout')

@section('main-view')
  <div id="tile-view" style="display:none">

  </div>
  <div id = "ajaxTest">test</div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#ajaxTest').load("{{ URL::to('/buildings') }}");
    });
  </script>
@endsection
