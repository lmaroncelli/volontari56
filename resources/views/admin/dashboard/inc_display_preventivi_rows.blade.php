
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
            <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                {{$preventivo->id}}
            </a>
        </td>
        <td>
            <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                @if (!is_null($preventivo->associazione))
                    {{$preventivo->associazione->nome}}
                @endif
            </a>
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
