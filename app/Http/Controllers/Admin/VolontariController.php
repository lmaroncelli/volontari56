<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Utility;
use App\Volontario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolontariController extends AdminController
{

  function __construct(Request $request)
  {
    $this->request = $request;
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($query_id = 0)
    {


    //  ricerca
    //
    $campo = "";
    $valore = "";

    if ($query_id > 0)
      {

      Utility::addQueryStringToRequest($query_id,$this->request);

      }



    /////////////////
    // ordinamento //
    /////////////////
    $order_by='cognome';
    $order = 'asc';
    $ordering = 0;

    if ($this->request->filled('order_by'))
      {
      $order_by=$this->request->get('order_by');
      $order = $this->request->get('order');
      $ordering = 1;
      }

    if ($order_by == 'associazione')
      {
      $order_by = "tblAssociazioni.nome";
      }


    $query = Volontario::with(['associazione'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
    {
      $join->on('tblAssociazioni.id', '=', 'tblVolontari.associazione_id');
    })
    ->select('tblVolontari.*','tblAssociazioni.nome as nome_asso');

    /////////////
    // ricerca //
    /////////////
    if ( $this->request->has('ricerca_campo') && $this->request->filled('q') )
      {

      $campo = $this->request->get('ricerca_campo');
      $valore = $this->request->get('q');


      if ($campo == 'nome_asso')
        {
        $campo = 'tblAssociazioni.nome';
        }
      elseif ($campo == 'nome')
        {
        $campo = 'tblVolontari.nome';
        }


      $query->where($campo, 'LIKE', "%$valore%");

      if ($campo == 'tblAssociazioni.nome')
        {
        $campo = 'nome_asso';
        }
      elseif ($campo == 'tblVolontari.nome')
        {
        $campo = 'nome';
        }

      }


    $volontari = $query
                  ->orderBy($order_by, $order)
                  ->paginate(15);



    $columns = [
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'registro' => 'Registro',
            'data_nascita' => 'Data di nascita',
            'associazione' => 'Associazione',
    ];

    if ($order_by == 'tblAssociazioni.nome')
      {
      $order_by = "associazione";
      }

    return view('admin.volontari.index', compact('volontari','order_by','order','ordering', 'columns','campo', 'valore'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $assos = Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();

    $volontario = new Volontario;

    return view('admin.volontari.form', compact('volontario','assos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //dd($request->all());

    /////////////////////////////////////////////////////////////////////
    // ho inserito il salvataggio della data come Carbon in un mutator //
    /////////////////////////////////////////////////////////////////////
    $volontario = Volontario::create($request->all());
    $volontario->save();

    return redirect('admin/volontari')->with('status', 'Volontario creato correttamente!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $volontario = Volontario::find($id);
        $assos = Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();

        $assos = ['0' => 'Seleziona...'] + $assos;

        return view('admin.volontari.form', compact('assos','volontario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $volontario = Volontario::find($id);
        /////////////////////////////////////////////////////////////////////
        // ho inserito il salvataggio della data come Carbon in un mutator //
        /////////////////////////////////////////////////////////////////////
        $volontario->fill($request->all());
        $volontario->save();

        return redirect('admin/volontari')->with('status', 'Volontario modificato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }



    public function search()
      {
      if ($this->request->has('search') && $this->request->filled('q'))
        {
        $query_id = Utility::createQueryStringSearch($this->request);
        return redirect("admin/volontari/$query_id");
        }
      else
        {
        return redirect("admin/volontari");
        }
      }
}
