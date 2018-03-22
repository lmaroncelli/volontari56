<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Controller;
use App\Preventivo;
use Illuminate\Http\Request;

class PreventiviController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
        {
        $preventivi = Preventivo::paginate(15);

        return view('admin.preventivi.index', compact('preventivi'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $assos = Associazione::all()->pluck('nome', 'id')->toArray();
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
        $preventivo = Preventivo::find($id);
        $volontari_associati = $preventivo->volontari->pluck('id')->toArray();
        $volontari = Volontario::get()->pluck('nome', 'id');
        return view('admin.preventivi.form', compact('preventivo','volontari','volontari_associati'));
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
}
