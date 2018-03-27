<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
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
    public function index()
    {

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
      $volontari = Volontario::with(['associazione'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
                    {
                      $join->on('tblAssociazioni.id', '=', 'tblVolontari.associazione_id');
                    })
                    ->select('tblVolontari.*')
                    ->orderBy('tblAssociazioni.nome', $order)
                    ->paginate(15);
      } 
    else 
      {
      $volontari = Volontario::with(['associazione'])->orderBy($order_by, $order)->paginate(15);
      }


    $columns = [
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'registro' => 'Registro',
            'data_nascita' => 'Data di nascita',
            'associazione' => 'Associazione',
    ];

    return view('admin.volontari.index', compact('volontari','order_by','order','ordering', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $assos = Associazione::all()->pluck('nome', 'id')->toArray();

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
        $assos = Associazione::orderBy('nome')->get()->pluck('nome', 'id')->toArray();

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
}
