<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset("favicon.ico") }}">

    <title>MUIFHMCCS</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style("css/bootstrap.min.css"); }}
    {{ HTML::style("css/bootstrap-theme.min.css"); }}

    <!-- Custom CSS -->
    {{ HTML::style("css/fms.css"); }}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{ HTML::script("js/jquery-1.9.1.min.js"); }}
    {{ HTML::script("js/bootstrap.min.js"); }}
    {{ HTML::script("js/spin.min.js"); }}
    {{ HTML::script("js/jquery.spin.js"); }}

    <!-- Custom JS -->
    {{ HTML::script("js/fms.js"); }}
  </head>

  <body>
    @include('navbars.header')
    <div class="container-fluid">

      
      <? 
      if (Session::has('msg')){
        $msg = Session::get('msg');
      }
      ?>

      @if (isset($msg))
        <div id="flash-message" class="flash alert alert-info" style="display:none">
          {{ $msg }}
          
          <button type="button" class="close" data-dismiss="alert" class="pull-right" style="padding-left: 10px">&times;</button>
        </div>

        <script type="text/javascript">
          $(document).ready(function(){  
            $("#flash-message").delay(500).slideDown();
          });
        </script>
      @endif

      @yield('content')
    </div>

    @include('navbars.footer')
    
  </body>
</html>
