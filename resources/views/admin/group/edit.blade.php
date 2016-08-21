@extends('layouts.app')

@section('htmlheader_title')
    Gruppenverwaltung
@endsection

@section('main-content')
    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Gruppe editieren</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($group, ['method' => 'PATCH', 'action' => ['GroupController@update', $group->id]]) !!}

                @include('/admin/group/_form', ['submitButton' => 'Editieren'])
            {!! Form::close() !!}
        </div>
    </div>
@endsection