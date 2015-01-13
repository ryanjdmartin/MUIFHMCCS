@extends('layout')

@section('content')
<div class="row">
  <div class="sidebar" id="sidebar">
    <div class="panel panel-default sidebar-panel">
      <div class="panel-heading">
	    <h4 class="panel-title">
	      <a href="#" data-toggle="collapse" data-target="#notifications-list">
	        Notifications 
            <span class="badge danger"><span class="glyphicon glyphicon-exclamation-sign"></span> 2</span>
            <span class="badge warning"><span class="glyphicon glyphicon-info-sign"></span> 5</span>
	      </a>
	    </h4>
      </div>
      <div class="panel-collapse notifications collapse in" id="notifications-list">
        <table class="table table-bordered table-striped table-hover">
          @for ($i=0; $i < rand(10,20); $i++)
            @if (rand(0,2) == 1)
            <tr class='text-danger'>
              <td>
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                A notification
              </td>
            </tr>
            @else
            <tr class='text-warning'>
              <td>
                <span class="glyphicon glyphicon-info-sign"></span>
                A notification
              </td>
            </tr>
            @endif
          @endfor
        </table>
      </div>
    </div>
  </div>

  <div class="main">
    <div class="navbar navbar-inverse main-nav">
      <span class='navbar-text'>
        Breadcrumb
      </span>
    </div>
    <div class="main-view">
      <div class="alert alert-info">Content</div>
    </div>
  </div>
</div>
@endsection
