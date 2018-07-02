<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Utility;
use App\Volontario;
use PDF;
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

    $filtro_pdf = [];
    $filtro_pdf[] = "<b>Filtri applicati:</b>";
    $export_pdf = 0;
    /////////////////////////////////////////////////////////////////
    // verifico se l'url ha un paramentro "pdf" nella query string //
    /////////////////////////////////////////////////////////////////
    if($this->request->has('pdf'))
      {
      $export_pdf = 1;
      }
     

    if(!$export_pdf)
      {
      // SE NON HO QUERY STRING 
      if ($this->request->fullUrl() == $this->request->url()) 
        {
        $pdf_export_url = $this->request->url() .'?pdf'; 
        } 
      else 
        {
        $pdf_export_url = $this->request->fullUrl() .'&pdf'; 
        }    
      }
    else
      {
      $pdf_export_url = $this->request->fullUrl();
      }


    //  ricerca
    //
    $campo = "";
    $valore = "";
    $assos = Associazione::getForSelect();
    $no_eliminati = 0;

    if ($query_id > 0)
      {

      Utility::addQueryStringToRequest($query_id,$this->request);

      }

    /////////////////
    // ordinamento //
    /////////////////
    $order_by='cognome';
    $order = 'asc';
    $associazione_id = 0;
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


    $query = Volontario::with(['associazione','utente'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
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

    if( $this->request->has('associazione_id') && $this->request->get('associazione_id') != 0 )
      {
      $associazione_id = $this->request->get('associazione_id');
      $query->where('tblVolontari.associazione_id', $associazione_id);

      $filtro_pdf[] =  "Associazione " . Associazione::find($associazione_id)->nome;
      }



    if ( !$this->request->has('no_eliminati') || $this->request->get('no_eliminati') != 1 )
      {
      $query->withTrashed();

      $filtro_pdf[] =  "<i>Compreso gli eliminati</i>";
      }
    else
      {
      $no_eliminati = $this->request->get('no_eliminati');
      
      $filtro_pdf[] =  "<i>Escluso gli eliminati</i>";
      }


    $query->orderBy($order_by, $order);
    
    if($export_pdf)
      {
      $volontari = $query->get();
      }
    else
      {
      $volontari = $query->paginate(15);
      }


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


    if($export_pdf)
      {
      $filtro_pdf[] =  "<b>N° volontari " .$volontari->count()."</b>";
      $chunked_element = 10;
      $pdf = PDF::loadView('admin.volontari.pdf', compact('volontari','chunked_element','columns','filtro_pdf'));

      if($this->request->get('pdf') == 'l')
        {
        $pdf->setPaper('a4', 'landscape');
        }
        
      return $pdf->stream();
      }
    else
      {
      $limit_for_export = 500;
      return view('admin.volontari.index', compact('volontari', 'assos', 'associazione_id', 'order_by','order','ordering', 'columns','campo', 'valore', 'no_eliminati', 'pdf_export_url','query_id', 'limit_for_export'));
      }
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
        $volontario = Volontario::with(['utente'])->withTrashed()->find($id);
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
    $volontario->fill($request->except('elimina'));
    $volontario->save();

    if ($request->filled('elimina') && $request->get('elimina') == 1) 
      {
      $volontario->delete();
      return redirect('admin/volontari')->with('status', 'Volontario eliminato!');
      } 
    else 
      {

      return redirect('admin/volontari')->with('status', 'Volontario modificato correttamente!');
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
    $volontario = Volontario::find($id);
    // Now, when you call the delete method on the model, the deleted_at column will be set to the current date and time. 
    // And, when querying a model that uses soft deletes, the soft deleted models will automatically be excluded from all query results.
    $volontario->delete();
    return redirect('admin/preventivi')->with('status', 'Preventivo eliminato!');
    }



    public function search()
      {
      if (
        $this->request->has('search') && $this->request->filled('q') ||
        ($this->request->has('associazione_id') && $this->request->get('associazione_id') != 0)||
        ($this->request->has('no_eliminati') && $this->request->get('no_eliminati') == 1) 
        )
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
