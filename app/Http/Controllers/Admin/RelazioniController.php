<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelazioniController extends Controller
{

    public function creaDaPreventivo()
      {
      dd('To do');
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_by='id';
        $order = 'desc';
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


        $query = Relazione::with(['associazione'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
                  {
                    $join->on('tblAssociazioni.id', '=', 'tblRelazioni.associazione_id');
                  })
                  ->select('tblRelazioni.*','tblAssociazioni.nome as nome_asso');

        $relazioni = $query
                      ->orderBy($order_by, $order)
                      ->paginate(15);

        $columns = [
            'id' => 'ID',
            'associazione' => 'Associazione',
            '' => 'Volontari',
            'dalle' => 'Data',
            'localita' => 'Località',
            'rapporto' => 'Rapporto',
            'auto' => 'Auto',
        ];

        if ($order_by == 'tblAssociazioni.nome')
        {
        $order_by = "associazione";
        }

        return view('admin.relazioni.index', compact('relazioni','order_by','order','ordering','columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $assos = ['0' => 'Seleziona'] + Associazione::all()->pluck('nome', 'id')->toArray();
      $volontari = [];
      $volontari_associati = [];
      $relazione = new Relazione;

      return view('admin.relazioni.form', compact('relazione','assos','volontari','volontari_associati'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
      $relazione = Relazione::find($id);
      $volontari = $relazione->associazione()->first()->getVolontariFullName();
      
      if (Auth::user()->hasRole('admin')) 
          {
          $volontari_associati = $relazione->volontari->pluck('id')->toArray();
          $assos = ['0' => 'Seleziona'] + Associazione::orderBy('nome')->get()->pluck('nome', 'id')->toArray();
          return view('admin.relazioni.form', compact('relazione', 'assos', 'volontari','volontari_associati'));
          } 
      else 
          {
          return view('admin.relazioni.form_asso', compact('relazione', 'volontari'));
          }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * [caricaVolontariAjax carica la combo dei volontari in funzione dell'associazione selezionata]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function caricaVolontariAjax(Request $request)
      {
      $associazione_id = $request->get('associazione_id');
      $relazione_id = $request->get('relazione_id');

      if ($associazione_id)
        {
        $volontari = Associazione::find($associazione_id)->getVolontariFullName();

        if ($relazione_id == '')
          {
          $volontari_associati = [];
          }
        else
          {
          $relazione = Relazione::find($relazione_id);
          $volontari_associati = $relazione->volontari->pluck('id')->toArray();
          }


        return view('admin.preventivi.inc_volontari_select', compact('volontari','volontari_associati'));
        }
      }
}