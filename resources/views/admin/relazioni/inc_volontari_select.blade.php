
<label for="volontari">Volontari:</label>
<select multiple="multiple" name="volontari[]" id="volontari" class="form-control select2" data-placeholder="@if (count($volontari)) Seleziona i volontari @else Scegli un'associazione per l'elenco dei volontari @endif " style="width: 100%;">
@foreach($volontari as $id => $nome)
	<option value="{{$id}}" @if ( in_array($id, $volontari_associati) || collect(old('volontari'))->contains($id) ) selected="selected" @endif>{{$nome}}</option>
@endforeach
</select>
