<tr class="success">
    <th>Spieler</th>
    @foreach($match_list as $i => $mt)

        <td><img src="{{$mt->club1->logo}}" class="team-logo"> {{$mt->erg1}}
            : {{$mt->erg2}} <img src="{{$mt->club2->logo}}" class="team-logo"></td>

    @endforeach
</tr>