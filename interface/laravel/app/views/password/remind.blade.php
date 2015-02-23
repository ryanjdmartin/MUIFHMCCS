@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <div class="row">
      <div class="col-md-4">
        <form action="{{ action('RemindersController@postRemind') }}" method="POST">
          <div class='form-group'>
            <label>Email:</label>
            <input type="email" name="email" class='form-control' placeholder='Enter Email'>
          </div>
          <div class='form-group'>
            <input type="submit" class='btn btn-default' value="Send Password Reset">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
