@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <form action="{{ action('RemindersController@postRemind') }}" method="POST" class="form-horizontal">
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-4">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <input type="submit" class="btn btn-default" value="Send Password Reset">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
