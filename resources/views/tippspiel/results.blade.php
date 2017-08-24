@extends('layouts.app')

@section('htmlheader_title')
    Tippspiel
@endsection

@section('main-content')

    <div class="row">
        @include('layouts.partials.flash')
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Tippergebnisse</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body text-center">
                <div class="box-tools">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    @include('layouts.partials.paginator', ['paginator' => $match_list])
                  </ul>
                </div>
                <table class="table results-table table-bordered table-hover display" cellspacing="0" width="100%">
                    <thead>
                        @include('tippspiel.partials.resultsTableHeader')
                    </thead>
                    <tfoot>
                        @include('tippspiel.partials.resultsTableHeader')
                    </tfoot>
                    <tbody>
                        @foreach($user_list as $u)
                            @if($u->user->id == Auth::user()->id)
                                <tr class="info">
                            @else
                                <tr>
                            @endif
                                <td class="col-sm-1">{{$u->user->name}}</td>


                                <td class="alert-success col-sm-1">
                                  {{calcMatchDayPoints($tipp_list, $u)}}
                                </td>
                                <td class="alert-success col-sm-1">
                                  {{$u->points}}
                                </td>

                                @foreach($tipp_list->where('group_user.user_id', $u->user->id) as $tipp)

                                        @if( (\Carbon\Carbon::now()->addMinutes(30) <= $tipp->match->date) && $u->user->id != Auth::user()->id)
                                            @if($tipp->home_team_bet !== null && $tipp->vis_team_bet !== null)
                                                <td class="alert alert-success col-sm-1">
                                                -:-
                                                </td>
                                            @else
                                                <td class="alert alert-warning col-sm-1">
                                                -:-
                                                </td>
                                            @endif
                                        @elseif($tipp->home_team_bet !== null && $tipp->vis_team_bet !== null)
                                            <td class="alert alert-success col-sm-1">
                                                {{ $tipp->home_team_bet }}:{{$tipp->vis_team_bet }} ({{calcMatchPoints($tipp)}})
                                            </td>
                                        @elseif($u->user->id == Auth::user()->id)
                                            <td class="alert alert-danger col-sm-1">
                                                -:-
                                            </td>
                                        @else
                                            <td class="alert alert-warning col-sm-1">
                                                -:-
                                            </td>
                                        @endif

                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3 col-md-push-4 text-center">
            <table class="table table-bordered table-condensed">
                <tbody>
                <tr class="alert-error">
                    <td>
                        (Eigene) Tipps noch nicht abgegeben.
                    </td>
                </tr>
                <tr class="alert-warning gd">
                    <td>
                        (Von Anderen) Tipps noch nicht abgegeben.
                    </td>
                </tr>
                <tr class="alert-success">
                    <td>
                        Tipps abgegeben. </br>
                        (Vor Spielbeginn nicht von anderen einsehbar)
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


@endsection