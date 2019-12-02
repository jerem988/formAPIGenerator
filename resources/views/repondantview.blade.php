@extends('layouts.front')
@section('content')
    <div id="app">
        <repondant-front :id_form_repondant="{{$id_form_repondant}}" :id_form="{{$form_id}}" :id_user="{{$user_id}}"></repondant-front>
    </div>
@endsection
@section('javascript')
@stop
