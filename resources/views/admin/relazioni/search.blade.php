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
       <div class="col-lg-2 col-sm-3">
          <button type="button" class="btn btn-default" id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Date range picker
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
       </div>
       <div class="col-lg-2 col-sm-3">
         <select class="form-control" name="anno_filtro" id="anno_filtro">
          @php
            $anno_corrente = (int)date('Y');
          @endphp
           @for ($y = -2; $y <2 ; $y++)
             @php
               $val = $anno_corrente + $y;
             @endphp
             <option value="{{ $val }}" @if ($anno_filtro == $val) selected="selected" @endif>{{$val}}</option>
           @endfor
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
    </div> 
    <div class="row" style="padding-bottom: 20px;">
        <div class="col-sm-3 col-sm-offset-1">
            <input type="text" name="q" class="form-control" placeholder="Cerca..." value="{{$valore}}">
        </div>
        <div class="col-sm-3">
          <select class="form-control" name="ricerca_campo" id="ricerca_campo">
            @foreach (['volontario' => 'elenco volontari', 'note' => 'note', 'rapporto' => 'rapporto', 'auto' => 'auto', 'preventivo_id' => 'ID preventivo','id' => 'ID relazione'] as $key => $nome)
              <option value="{{$key}}" @if ($campo == $key) selected="selected" @endif>{{$nome}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" name="search" id="search-btn" class="btn btn-info"><i class="fa fa-search"></i></button>
            <a href="{{ url('admin/relazioni') }}" title="annulla filtri" class="btn btn-warning"><i class="fa fa-close"></i></a>
        </div>
        <div class="col-sm-3">
          @if ($relazioni->total() > 0 && $relazioni->total() <= $limit_for_export)
            <a href="{{$pdf_export_url}}" title="Esporta" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{$pdf_export_url}}=l" title="Esporta Landscape" target="_blank" class="btn btn-danger" style="width: 80px"><i class="fa fa-file-pdf-o"></i></a>
          @endif
        </div>
    </div>
    </form>

    <form action="{!! route('relazioni.export_ore') !!}" id="export_ore" method="post" target="_blank">
      {{ csrf_field() }}
      @php
        $anno_corrente = (int)date('Y');
      @endphp
      <div class="row">
         <div class="col-sm-3 col-sm-offset-1">
           <select class="form-control" style="width: 100%;" name="associazione_id_ore" id="associazione_id_ore">
             @foreach ($assos_ore as $id => $nome)
              <option value="{{$id}}">{{$nome}}</option>
             @endforeach
           </select>
         </div>
         <div class="col-sm-2">
          <select class="form-control" name="anno_ore" id="anno_ore">
            @for ($y = -2; $y <2 ; $y++)
              @php
                $val = $anno_corrente + $y;
              @endphp
              <option value="{{ $val }}" @if ($y==0) selected="selected" @endif>{{$val}}</option>
            @endfor
          </select>
         </div>
         <div class="col-sm-1">
          <button type="submit" title="Riepilogo ore di servizio" name="ore-servizio" id="ore-servizio-btn" class="btn btn-primary"><i class="fa fa-safari"></i></button>
         </div>
    </form>

</div>