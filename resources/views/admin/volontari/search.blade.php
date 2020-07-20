<div class="box" style="position: initial; margin-top: 20px;">
    
    <div class="box-header">
      <h3 class="box-title">Filtri</h3>
    </div>

    <form action="{!! route('volontari.search') !!}" method="post">
      {{ csrf_field() }}

      <div class="row">
       <div class="col-sm-3 col-sm-offset-1">
         <select class="form-control" style="width: 100%;" name="associazione_id" id="associazione_id">
           @foreach ($assos as $id => $nome)
            <option value="{{$id}}" @if ($associazione_id == $id) selected="selected" @endif>{{$nome}}</option>
           @endforeach
         </select>
       </div>
       <div class="col-sm-2">
        <div class="checkbox">
          <label>
           <input type="checkbox" name="no_eliminati" value="1" @if ($no_eliminati) checked="checked" @endif>
            Escludi "Eliminati"
          </label>
        </div>
       </div>
       <div class="col-sm-2">
        <div class="checkbox">
          <label>
           <input type="checkbox" name="only_login" value="1" @if ($only_login) checked="checked" @endif>
            Solo "Login"
          </label>
        </div>
       </div>
    </div> 
    <div class="row" style="padding-bottom: 20px;">
        <div class="col-sm-3 col-sm-offset-1">
            <input type="text" name="q" class="form-control" placeholder="Cerca..." value="{{$valore}}">
        </div>
        <div class="col-sm-3">
          <select class="form-control" name="ricerca_campo" id="ricerca_campo">
           @foreach (['nome' => 'nome volontario','cognome' => 'cognome volontario'] as $key => $nome)
             <option value="{{$key}}" @if ($campo == $key) selected="selected" @endif>{{$nome}}</option>
           @endforeach
          </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" name="search" id="search-btn" class="btn btn-info"><i class="fa fa-search"></i></button>
            <a href="{{ url('admin/volontari') }}" title="annulla filtri" class="btn btn-warning"><i class="fa fa-close"></i></a>
        </div>
        <div class="col-sm-3">
          @if ($volontari->total() > 0 && $volontari->total() <= $limit_for_export)
            <a href="{{$pdf_export_url}}" title="Esporta" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{$pdf_export_url}}=l" title="Esporta Landscape" target="_blank" class="btn btn-danger" style="width: 80px"><i class="fa fa-file-pdf-o"></i></a>
          @endif
        </div>
    </div>
    </form>

</div>