
@if (!count($preventivi))
    <tr>
        <td colspan="7" style="height: 80px; font-weight: bold; text-align: center; vertical-align: middle;">Nessun preventivo scade {{$title}}</td>
    </tr>
@else
    @foreach ($preventivi as $preventivo)
    <tr>
        <td>
            {!!$preventivo->displayInTime()!!}
        </td>
        <td>
            @if (Auth::user()->hasRole('GGV Semplice'))
                {{$preventivo->id}}
            @else
                <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                    {{$preventivo->id}}
                </a>
            @endif
        </td>
        <td>
            @if (!is_null($preventivo->associazione))
                @if (Auth::user()->hasRole('GGV Semplice'))
                    {{$preventivo->associazione->nome}}
                @else
                    <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                        {{$preventivo->associazione->nome}}
                    </a>
                @endif
            @endif
        </td>
        <td>
            {{ implode( ', ', $preventivo->getVolontariFullName() ) }}
        </td>
        <td>
            {{$preventivo->getDalleAlle()}}
        </td>
        <td>
            {{$preventivo->localita}}
        </td>
        <td>
            {{$preventivo->motivazioni}}
        </td>
    </tr>
    @endforeach
@endif
