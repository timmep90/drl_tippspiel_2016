@extends('layouts.app')

@section('htmlheader_title')
    Tippspiel
@endsection

@section('main-content')
    <div class="row">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Tipptabelle</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body text-center">
                <table class="table standard-table table-striped table-bordered text-center">
                    <thead>
                    <tr class="success">
                        <th class="max-tablet-p"></th>
                        <th id="name" class="all">Spieler</th>
                        <th class="all">Punkte</th>
                        <th class="min-tablet-l">Kopftipp</th>
                        <th class="min-tablet-l">Tendenztipp</th>
                        <th class="min-tablet-l">Siegertipp</th>
                        <th class="min-tablet-l">Fehltipp</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr class="success">
                        <th class="max-tablet-p"></th>
                        <th class="all">Spieler</th>
                        <th class="all">Punkte</th>
                        <th class="min-tablet-l">Kopftipp</th>
                        <th class="min-tablet-l">Tendenztipp</th>
                        <th class="min-tablet-l">Siegertipp</th>
                        <th class="min-tablet-l">Fehltipp</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($user_groups as $ug)
                        <tr class="{{($ug->id == Auth::user()->id)? 'info': ''}}">
                            <td class="details-control"></td>
                            <td>{{$ug->user->name}}</td>
                            <td>{{$ug->points}}</td>
                            <td>{{$ug->kt}}</td>
                            <td>{{$ug->tt}}</td>
                            <td>{{$ug->st}}</td>
                            <td>{{$ug->m}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection