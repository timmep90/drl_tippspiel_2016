@extends('layouts.app')

@section('htmlheader_title')
    Tippspiel
@endsection

@section('main-content')
    <div class="row">
        @include('layouts.partials.errors')

        <div class="box box-success ">
            <div class="box-header">
                <h3 class="box-title">Tipps abgeben</h3>

                <div class="box-tools">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        @include('layouts.partials.paginator', ['paginator' => $mt_list])
                    </ul>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body text-center">
                {{ Form::open(array('action' => array('TippController@update', $group->id))) }}

                @foreach($mt_list as $i => $mt)
                        @if($i % 3 == 0)
                            <div class = "row">
                        @endif
                            <div class="col-md-4">
                                <div class="box box-success box-solid">
                                    <div class="box-header">
                                        <h4><i>{{\Carbon\Carbon::parse($mt->match->date)->format('d.m.Y H:i')}}</i></h4>
                                        <h3 class="box-title"> {{$mt->match->home_team->name}}  : {{$mt->match->vis_team->name}} </h3>
                                    </div>

                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-lg-3">
                                            @if(\Carbon\Carbon::now()->addMinutes(30) < $mt->match->date)
                                                {{Form::text('club1_tipp['.$mt->id.']', $mt->home_team_bet, ["class"=>"form-control"])}}
                                            @else
                                                {{Form::text('club1_tipp['.$mt->id.']', $mt->home_team_bet, ["class"=>"form-control", "disabled"])}}
                                            @endif
                                        </div>
                                        <div class="col-lg-5">
                                            <img src="{{$mt->match->home_team->logo}}" class="team-logo"> {{$mt->match->home_team_erg}}
                                            : {{$mt->match->vis_team_erg}} <img src="{{$mt->match->vis_team->logo}}" class="team-logo">
                                        </div>
                                        <div class="col-lg-3">
                                            @if(\Carbon\Carbon::now()->addMinutes(30) < $mt->match->date)
                                                {{Form::text('club2_tipp['.$mt->id.']',  $mt->vis_team_bet, ["class"=>"form-control"])}}
                                            @else
                                                {{Form::text('club2_tipp['.$mt->id.']',  $mt->vis_team_bet, ["class"=>"form-control", "disabled"])}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @if($i % 3 == 2)
                            </div>
                        @endif
                    @endforeach
                {{Form::submit('Tipps absenden', ['class' => 'btn btn-block btn-success btn-lg'])}}
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection