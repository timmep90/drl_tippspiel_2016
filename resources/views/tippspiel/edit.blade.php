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
                                        <h4><i>{{$mt->match->match_datetime->format('d.m.Y H:i')}}</i></h4>
                                        <h3 class="box-title"> {{$mt->match->club1->name}}  : {{$mt->match->club2->name}} </h3>
                                    </div>

                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            @if(\Carbon\Carbon::now()->addMinutes(30) < $mt->match->match_datetime)
                                                {{Form::text('club1_tipp['.$mt->id.']', $mt->t1, ["class"=>"form-control"])}}
                                            @else
                                                {{Form::text('club1_tipp['.$mt->id.']', $mt->t1, ["class"=>"form-control", "disabled"])}}
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{$mt->match->club1->logo}}" class="team-logo"> {{$mt->match->erg1}}
                                            : {{$mt->match->erg2}} <img src="{{$mt->match->club2->logo}}" class="team-logo">
                                        </div>
                                        <div class="col-md-3">
                                            @if(\Carbon\Carbon::now()->addMinutes(30) < $mt->match->match_datetime)
                                                {{Form::text('club2_tipp['.$mt->id.']',  $mt->t2, ["class"=>"form-control"])}}
                                            @else
                                                {{Form::text('club2_tipp['.$mt->id.']',  $mt->t2, ["class"=>"form-control", "disabled"])}}
                                            @endif
                                        </div>
                                        <div class="col-md-1"></div>
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