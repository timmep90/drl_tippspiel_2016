<!-- text input -->
<div class="form-group">
    {{ Form::label('name', 'Gruppenname:') }}
    {{Form::text('name', null, ["class"=>"form-control", 'placeholder' => "Mein Gruppenname"])}}

    {{ Form::label('league', 'Tippliga:') }}
    {{ Form::select("league", $leagues, null, ['class' => 'form-control']) }}

    {{ Form::label('admin', 'Administrator:') }}
    {{ Form::select("admin", $users, null, ['class' => 'form-control']) }}


    {{ Form::label('isActive', 'Aktiv?') }}
    {{ Form::checkbox('isActive', null, true) }}
    {!! Form::submit($submitButton, ['class'=>'btn-success']) !!}


</div>