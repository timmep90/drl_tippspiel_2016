@extends('layouts.app')

@section('htmlheader_title')
    Gruppenverwaltung
@endsection

@section('main-content')
    <a href="{{ action('GroupController@create') }}" class="btn-lg btn-success"><i class="fa fa-group"></i> Neue Gruppe </a>

    @foreach($groups as $i => $group)
        @if($i % 2 == 0)
        <div class="row">
        @endif
            <div class="col-md-6">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        {{$group->name}}
                    </div>
                    <div class="box-body">
                        <div class="col-md-12 row">
                            Typ: {{$group->league->name}}
                        </div>
                        <a href="{{ action('GroupController@edit', ['id' => $group->id]) }}" class="btn btn-success pull-left"><i class="fa fa-edit"></i> Gruppe editieren </a>

                        {{Form::open(array('action' => 'GroupController@destroyFast', 'method'=>'DELETE'))}}
                            {{Form::hidden('id', $group->id)}}
                            {{Form::submit('Gruppe löschen', ['class' => "btn btn-danger pull-right "])}}
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        @if($i % 2 == 1)
        </div>
        @endif
    @endforeach
@endsection