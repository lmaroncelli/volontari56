<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\AssociazioneRequest;
use App\Volontario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssociazioniController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assos = Associazione::orderBy('nome')->get();
        return view('admin.associazioni.index', compact('assos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* 
    public function create()
      {
      $asso = new Associazione;
      return view('admin.associazioni.form', compact('asso'));
      }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*   
    public function store(AssociazioneRequest $request)
        {
        Associazione::create($request->all());

        return redirect('admin/associazioni')->with('status', 'Associazione creata correttamente!');

        }*/

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
      $asso = Associazione::find($id);
      $volontari = [];


      // i volontari tra cui posso scegliere sono
      // - quelli che NON SONO ASSOCIATI A NESSUNA ASSOCIAZIONE
      // - quelli già associati

      $volontari_liberi =  Volontario::doesntHave('associazione')->get();
      $volontari_associati = $asso->volontari;

      $volontari_totali = $volontari_liberi->merge($volontari_associati);

      foreach ($volontari_totali as $v)
        {
        $volontari[$v->id] = $v->cognome .' ' .$v->nome;
        }

      $volontari_associati_ids = $volontari_associati->pluck('id')->toArray();

      return view('admin.associazioni.form', compact('asso','volontari','volontari_associati_ids'));

      }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssociazioneRequest $request, $id)
      {
      $asso = Associazione::find($id);
      $asso->nome = $request->get('nome');

      DB::beginTransaction();
      $status = 'ok';


      try
        {

        foreach ($asso->volontari as $v)
          {
          $v->associazione_id = 0;
          $v->save();
          }

        $volontari_da_asscociare_ids = $request->get('volontari');

        if (!is_null($volontari_da_asscociare_ids)) 
          {
          foreach ($volontari_da_asscociare_ids as $id)
            {
            $v = Volontario::find($id);
            $asso->volontari()->save($v);
            }
         } 

        $asso->save();

         DB::commit();

        }
      catch (\Exception $e)
        {
        $status = 'ko';
        DB::rollback();
        }

      if ($status == 'ok')
        {
        return redirect('admin/associazioni')->with('status', 'Associazione modificata correttamente!');
        }
      else
        {
        return redirect('admin/associazioni')->with('status', 'ERRORE!');
        }

      }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
      {

      $asso = Associazione::find($id);
      $nome_asso = $asso->nome;
      
      DB::beginTransaction();
      $status = 'ok';

      try
        {

        foreach ($asso->volontari as $v)
          {
          $v->associazione_id = 0;
          $v->save();
          }

        $asso->utente->delete();

        $asso->delete();
         
        DB::commit();
        
        }
      catch (\Exception $e)
        {

        $status = 'ko';
        DB::rollback();
        
        }

      if ($status == 'ok')
        {
        return redirect('admin/associazioni')->with('status', 'Associazione "'.$nome_asso.'" eliminata correttamente!');
        }
      else
        {
        return redirect('admin/associazioni')->with('status', 'ERRORE!');
        }

      }
}
