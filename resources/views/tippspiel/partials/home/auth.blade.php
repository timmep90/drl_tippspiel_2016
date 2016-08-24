@foreach($groups as $i => $group)

    @if($i%2 == 0)
    <div class="row">
    @endif

        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h4 class="col-md-8">
                        {{$group->name}}
                    </h4>
                    <h5>
                        {{$group->league->name}}
                    </h5>
                </div>
                <div class="box-body">
                    <div class = "col-md-12">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th> Regel </th>
                                <th> Punkte </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td> Kopftipp </td>
                                <td> {{$group->kt_points}} </td>
                            </tr>
                            <tr>
                                <td> Tendenztipp </td>
                                <td> {{$group->tt_points}}</td>
                            </tr>
                            <tr>
                                <td> Siegertipp </td>
                                <td> {{$group->st_points}} </td>
                            </tr>
                            <tr>
                                <td> Fehltipp </td>
                                <td> {{$group->m_points}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @if($group->group_user->where('user_id', Auth::user()->id)->isEmpty())
                        {{Form::open(array('action' => 'HomeController@joinGroup'))}}
                        {{Form::hidden('id', $group->id)}}
                        {{Form::submit('Gruppe beitreten', ['class' => "btn btn-success pull-right "])}}
                        {{Form::close()}}
                    @elseif($group->group_user->where('user_id', Auth::user()->id)->where('pending', 0)->isEmpty())
                        <i class="pull-right">Warten auf Annahme....</i>
                    @else
                        <a href="{{ action('TippController@edit', ['id' => $group->id]) }}" class="btn btn-success pull-right"> Tipps abgeben </a>

                    @endif
                </div>
            </div>
        </div>

    @if($i%2 == 1)
    </div>
    @endif

@endforeach