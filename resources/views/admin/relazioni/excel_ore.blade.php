<table>
    <thead>
    <tr>
        <th>Associazione</th>
        <th>Volontario</th>
        <th>Totale ore</th>
    </tr>
    </thead>
    <tbody>
    @foreach($volontari as $volontario)
        <tr>
            <td>{{ $volontario['Associazione'] }}</td>
            <td>{{ $volontario['Volontario'] }}</td>
            <td>{{ $volontario['Totale ore'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
