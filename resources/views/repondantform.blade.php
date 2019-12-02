@extends('layouts.app')
@section('content')
    <div id="app">
        <repondant-form-select :id_form="{{$id}}"></repondant-form-select>
    </div>
@endsection
@section('javascript')
@stop
