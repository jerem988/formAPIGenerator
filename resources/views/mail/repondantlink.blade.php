@extends('layouts.mail')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Enquête de satisfaction
            </div>
            <div class="card-body">
                <p class="card-title h5">Bonjour !</p>
                <br>
                <p class="card-text h6">Merci de répondre à notre enquête de satisfaction en cliquant sur le boutton suivant:</p>
                <a href="{{ url('enquete-de-satisafication'). '/' . $data->id_form_repondant . '/' . $data->form_id . '/' .$data->user_id }}" class="btn btn-primary h6">Répondre à l'enquête</a>
                <br>
                <br>
                <p class="card-text h6">Cordialement, </p>
                <p class="card-text h6">L'équipe Form Creator</p>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@stop
