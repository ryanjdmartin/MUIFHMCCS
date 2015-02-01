@extends('home-layout')

@section('main-view')
  <div id="tile-view" style="display:none">
  </div>

  <table id="list-view" style="display:none;" class="table table-striped table-hover">
  </table>

  <script type="text/javascript">
  $(document).ready(function(){
    tileView();
  });
  </script>
@endsection
