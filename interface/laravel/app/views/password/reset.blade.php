@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <div class="row">
      <div class="col-md-4">
        <form action="{{ action('RemindersController@postReset') }}" method="POST">
          <input type="hidden" name="token" value="{{ $token }}">
          <div class='form-group'>
            <label>Email:</label>
            <input type="email" name="email" class='form-control' placeholder='Enter Email'>
          </div>
          <div class='form-group'>
            <label>New Password:</label>
            <input type="password" name="password" class='form-control' placeholder='Enter New Password'>
          </div>
          <div class='form-group'>
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" class='form-control' placeholder='Confirm New Password'>
          </div>
          <div class='form-group'>
            <input type="submit" class='btn btn-default' value="Reset Password">
          </div>
        </form>
      </div>
    </div>
    </form>
  </div>
</div>
@endsection
