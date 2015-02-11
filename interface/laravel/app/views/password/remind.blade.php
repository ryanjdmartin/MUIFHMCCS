@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <form action="{{ action('RemindersController@postRemind') }}" method="POST">
      <input type="email" name="email">
      <input type="submit" value="Send Password Reset">
    </form>
  </div>
</div>
@endsection
