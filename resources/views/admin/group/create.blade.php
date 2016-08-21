@extends('layouts.app')

@section('htmlheader_title')
    Gruppenverwaltung
@endsection

@section('main-content')
    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Neue Gruppe erstellen</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(array('action' => 'GroupController@store')) !!}
                 @include('/admin/group/_form', ['submitButton' => 'Erstellen'])
            {!! Form::close() !!}
        </div>

    </div>


@endsection