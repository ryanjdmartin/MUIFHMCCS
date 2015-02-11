@extends('layout')

@section('content')
<div class="row">
  @include('parts.notifications')

  @yield('main-view')
</div>
@endsection
