@extends('home-layout')

@section('main-view')
  @for ($i=1; $i < rand(15,30); $i++)
    <button class="btn btn-lg" style="width: 200px; margin-bottom: 20px;">Item {{ $i }}</button>
  @endfor
@endsection
