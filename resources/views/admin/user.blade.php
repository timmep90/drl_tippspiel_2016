@extends('layouts.app')

@section('htmlheader_title')
    Benutzerverwaltung
@endsection

@section('main-content')
    {{ Form::open(array('action' => 'UserController@update')) }}
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Benutzerverwaltung</h3>

                <div class="box-tools">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        @include('layouts.partials.paginator', ['paginator' => $users])
                    </ul>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table">
                    <thead>
                        <tr>
                            <th >#</th>
                            <th>Username</th>
                            <th>email</th>
                            <th>Rang</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ Form::select("user_types[".$user->id."]", $user_types, $user->user_type_id, ['class' => 'form-control']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ Form::submit('Submit!', ['class' => 'submit btn-lg btn-success btn-block']) }}
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    {{ Form::close() }}
@endsection