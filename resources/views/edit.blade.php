@extends('layouts.app')
@section('content')
    <div id="app">
        <form-builder action="edition" :id="{{$id}}"></form-builder>
    </div>
@endsection
@section('javascript')
@stop
