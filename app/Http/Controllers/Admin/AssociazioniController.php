<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\AssociazioneRequest;
use App\Volontario;
use Illuminate\Http\Request;

class AssociazioniController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assos = Associazione::all();
        return view('admin.associazioni.index', compact('assos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
      {
      $asso = new Associazione;
      return view('admin.associazioni.form', compact('asso'));
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssociazioneRequest $request)
        {
        Associazione::create($request->all());
        
        return redirect('admin/associazioni')->with('status', 'Associazione creata correttamente!');  

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
      $asso = Associazione::find($id);

      $volontari = Volontario::get()->pluck('nome', 'id');
      $volontari_associati = $asso->volontari->pluck('id')->toArray();
      return view('admin.associazioni.form', compact('asso','volontari','volontari_associati'));
      
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
      $asso->save();

      return redirect('admin/associazioni')->with('status', 'Associazione modificata correttamente!');  
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
}
