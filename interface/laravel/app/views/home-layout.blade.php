@extends('layout')

@section('content')
{{ HTML::script("js/jquery.loadTemplate-1.4.5.min.js"); }}
<div class="row">
  @yield('main-view')
</div>
@endsection
