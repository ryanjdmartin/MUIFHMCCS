@extends('home-layout')

@section('main-view')
  <table class="table table-striped table-hover">
    @for ($i=1; $i < rand(15,30); $i++)
      <tr>
        <td>Item {{ $i }}</td>
      </tr>
    @endfor
  </table>
@endsection
