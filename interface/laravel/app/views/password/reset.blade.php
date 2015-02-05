@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Reset Password
    </h1>
    <form action="{{ action('RemindersController@postReset') }}" method="POST">
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="email" name="email">
      <input type="password" name="password">
      <input type="password" name="password_confirmation">
      <input type="submit" value="Reset Password">
    </form>
  </div>
</div>
@endsection
