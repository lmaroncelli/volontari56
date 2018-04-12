<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Preventivo;
use App\Volontario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventiviController extends AdminController
{


    public function _savePreventivo(&$preventivo, $request)
      {
        $dalle = $request-get('data'). ' ' . $request-get('dal');
        $alle = $request-get('data'). ' ' . $request-get('al');

        $preventivo->associazione_id = $request-get('associazione_id');
        $preventivo->dalle = Utility::getCarbonDateTime($dalle);
        $preventivo->alle = Utility::getCarbonDateTime($alle);
        $preventivo->localita = $request-get('localita');
        $preventivo->motivazioni = $request-get('motivazioni');
        $preventivo->volontari()->sync($request-get('volontari'));
        $preventivo->save();
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


        $query = Preventivo::with(['associazione'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
                  {
                    $join->on('tblAssociazioni.id', '=', 'tblPreventivi.associazione_id');
                  })
                  ->select('tblPreventivi.*','tblAssociazioni.nome as nome_asso');

        $preventivi = $query
                      ->orderBy($order_by, $order)
                      ->paginate(15);

        $columns = [
            'id' => 'ID',
            'associazione' => 'Associazione',
            '' => 'Volontari',
            'dalle' => 'Data',
            'localita' => 'Località',
            'motivazioni' => 'Motivazione',
        ];

        if ($order_by == 'tblAssociazioni.nome')
        {
        $order_by = "associazione";
        }

        return view('admin.preventivi.index', compact('preventivi','order_by','order','ordering','columns'));


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
    $preventivo = new Preventivo;

    return view('admin.preventivi.form', compact('preventivo','assos','volontari','volontari_associati'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        dd($request->all());
        array:8 [▼
          "_token" => "cpHqOGMoOa2k2PFcCB9OWThKcDJy95t1OvMoXVNb"
          "associazione_id" => "2"
          "volontari" => array:2 [▼
            0 => "1295"
            1 => "1297"
          ]
          "data" => "27/04/2018"
          "dal" => "10:00"
          "al" => "10:00"
          "localita" => "asas"
          "motivazione" => "ddd"
        ]
         */
      $preventivo = new Preventivo;
      $this->_savePreventivo($preventivo, $request);

      return redirect('admin/preventivi')->with('status', 'Preventivo creato correttamente!');

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

        $preventivo = Preventivo::find($id);
        $volontari = $preventivo->associazione()->first()->getVolontariFullName();
        
        if (Auth::user()->hasRole('admin')) 
            {
            $volontari_associati = $preventivo->volontari->pluck('id')->toArray();
            $assos = ['0' => 'Seleziona'] + Associazione::orderBy('nome')->get()->pluck('nome', 'id')->toArray();
            return view('admin.preventivi.form', compact('preventivo', 'assos', 'volontari','volontari_associati'));
            } 
        else 
            {
            return view('admin.preventivi.form_asso', compact('preventivo', 'volontari'));
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
        $preventivo = Preventivo::find($id);
        $this->_savePreventivo($preventivo, $request);

        return redirect('admin/preventivi')->with('status', 'Preventivo modificato correttamente!');

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
      $preventivo_id = $request->get('preventivo_id');

      if ($associazione_id)
        {
        $volontari = Associazione::find($associazione_id)->getVolontariFullName();

        if ($preventivo_id == '')
          {
          $volontari_associati = [];
          }
        else
          {
          $preventivo = Preventivo::find($preventivo_id);
          $volontari_associati = $preventivo->volontari->pluck('id')->toArray();
          }


        return view('admin.preventivi.inc_volontari_select', compact('volontari','volontari_associati'));
        }
      }
}
