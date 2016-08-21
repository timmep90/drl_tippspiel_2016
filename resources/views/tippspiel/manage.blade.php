@extends('layouts.app')

@section('htmlheader_title')
    Benutzerverwaltung
@endsection

@section('main-content')
    <div class ="row">
        {{ Form::open(array('action' => array('TippAdminController@manageUpdate', 'id' => $users->first()->group_id))) }}

        <div class="col-md-6">
            @include('tippspiel.partials.admin.user')
        </div>
        <div class="col-md-6">
            @include('tippspiel.partials.admin.settings')
        </div>
        {{ Form::submit('Submit and Update! (Nimmt etwas Zeit in Anspruch wenn neue Daten verfügbar sind.)', ['class' => 'submit btn-lg btn-success btn-block']) }}
        {{ Form::close() }}

        @include('layouts.partials.errors')

    </div>
@endsection