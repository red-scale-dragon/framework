@extends('layouts.app')

@section('content')
  <h1>Welcome</h1>
  <img src="@image('dragon.png')" />
  <h2>Plugin Meta Data</h2>
  <p>{!! nl2br(\Dragon\Support\Plugin::getData()) !!}</p>
@endsection
