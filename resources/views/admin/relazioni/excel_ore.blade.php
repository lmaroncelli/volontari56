


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Export ore servizio</title>
    <style type="text/css" media="screen">
        th.filtro {
            height: 100px;
        }
    </style>
</head>
<body>

    <table>
        <thead>
        <tr>
            <th colspan="{{count($columns)}}" class="filtro">
                {!! implode(' ', $filtro_ore) !!}
            </th>
        </tr>
        <tr>
            @foreach ($columns as $column)
                <th>{{$column}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($volontari as $volontario)
            <tr>
                @foreach ($columns as $column)
                    @if ($column == 'Totale ore')
                      <td nowrap="nowrap">
                      {{Utility::getHoursForView($volontario[$column])}}
                      </td>
                    @else
                      <td>
                      {{$volontario[$column]}}
                      </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    
    
</body>
</html>


