@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <form action="{{ action('RemindersController@postReset') }}" method="POST" class="form-horizontal">
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-4">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
      </div>
      <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
      </div>
      <div class="form-group">
        <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <input type="submit" class="btn btn-default" value="Reset Password">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
