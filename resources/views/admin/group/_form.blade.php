<!-- text input -->
<div class="form-group">
    {{ Form::label('name', 'Gruppenname:') }}
    {{Form::text('name', null, ["class"=>"form-control", 'placeholder' => "Mein Gruppenname"])}}

    {{ Form::label('match_type', 'Tippliga:') }}
    {{ Form::select("match_type", $match_type_list, null, ['class' => 'form-control']) }}

    {{ Form::label('year', 'Gruppenname:') }}
    {{ Form::text('year', null, ["class"=>"form-control", 'placeholder' => "Startjahr der Saison"])}}

    {{ Form::label('admin', 'Administrator:') }}
    {{ Form::select("admin", $users, null, ['class' => 'form-control']) }}


    {{ Form::label('isActive', 'Aktiv?') }}
    {{ Form::checkbox('isActive', null, true) }}
    {!! Form::submit($submitButton, ['class'=>'btn-success']) !!}


</div>