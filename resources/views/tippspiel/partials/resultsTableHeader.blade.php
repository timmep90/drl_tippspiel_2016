<tr class="success">
    <th>Spieler</th>
    @foreach($match_list as $i => $mt)

        <td><img src="{{$mt->home_team->logo}}" class="team-logo"> {{$mt->home_team_erg}}
            : {{$mt->vis_team_erg}} <img src="{{$mt->vis_team->logo}}" class="team-logo"></td>

    @endforeach
    <td>Spieltag</td>
    <td>Total</td>
</tr>