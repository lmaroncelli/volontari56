
<label for="volontari">Volontari:</label>
<select multiple="multiple" name="volontari[]" id="volontari" class="form-control select2" data-placeholder="Seleziona i volontari" style="width: 100%;">
@foreach($volontari as $id => $nome)
	<option value="{{$id}}" @if ( in_array($id, $volontari_associati) || collect(old('volontari'))->contains($id) ) selected="selected" @endif>{{$nome}}</option>
@endforeach
</select>
