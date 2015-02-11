@extends('layout')

@section('content')
<div class="row">
  @include('parts.notifications')

  <div class="main">
    @include('navbars.main-nav')

    <div class="main-view">
      @yield('main-view')
    </div>
  </div>
</div>
@endsection
