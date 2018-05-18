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
        </div>
        <div class="row">
            <div class="col-sm-2">
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cerca..." required value="{{$valore}}">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
            <div class="col-sm-3">
              <select class="form-control" name="ricerca_campo" id="ricerca_campo">
                @foreach (['nome' => 'nome volontario','cognome' => 'cognome volontario', 'nome_asso' => 'associazione'] as $key => $nome)
                  <option value="{{$key}}" @if ($campo == $key) selected="selected" @endif>{{$nome}}</option>
                @endforeach
              </select>
            </div>
        </div>
        </form>