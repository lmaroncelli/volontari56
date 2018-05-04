<div class="box" style="position: initial; margin-top: 20px;">
  <div class="box-header">
      <h3 class="box-title">Filtri</h3>
    </div>
    <form action="{!! route('relazioni.search') !!}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="cerca_dal" id="cerca_dal" value="{{$dal}}">
      <input type="hidden" name="cerca_al" id="cerca_al" value="{{$al}}">

    <div class="row">
       <div class="col-sm-3 col-sm-offset-1">
         <select class="form-control" style="width: 100%;" name="associazione_id" id="associazione_id">
           @foreach ($assos as $id => $nome)
            <option value="{{$id}}" @if ($associazione_id == $id) selected="selected" @endif>{{$nome}}</option>
           @endforeach
         </select>
       </div>
       <div class="col-sm-3">
          <button type="button" class="btn btn-default" id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Date range picker
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
       </div>
    </div> 
    <div class="row" style="padding-bottom: 20px;">
        <div class="col-sm-3 col-sm-offset-1">
            <input type="text" name="q" class="form-control" placeholder="Cerca..." value="{{$valore}}">
        </div>
        <div class="col-sm-3">
          <select class="form-control" name="ricerca_campo" id="ricerca_campo">
            @foreach (['volontario' => 'elenco volontari', 'note' => 'note', 'rapporto' => 'rapporto', 'auto' => 'auto', 'preventivo_id' => 'preventivo'] as $key => $nome)
              <option value="{{$key}}" @if ($campo == $key) selected="selected" @endif>{{$nome}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" name="search" id="search-btn" class="btn btn-info"><i class="fa fa-search"></i></button>
            <a href="{{ url('admin/relazioni') }}" title="annulla filtri" class="btn btn-warning"><i class="fa fa-close"></i></a>
        </div>
        <div class="col-sm-3">
          @if ($query_id > 0)
            <a href="{{$pdf_export_url}}" title="Esporta" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
          @endif
        </div>
    </div>
    </form>
</div>