<tr class="success">
    <th class="all">Spieler</th>
    <th class="all">Spieltag</th>
    <th class="all">Total</th>
    @foreach($match_list as $i => $mt)

        <th class="min-tablet-l">
            <img src="{{$mt->home_team->logo}}" class="team-logo">
            {{$mt->home_team_erg}}:{{$mt->vis_team_erg}}
            <img src="{{$mt->vis_team->logo}}" class="team-logo">
        </th>

    @endforeach
</tr>