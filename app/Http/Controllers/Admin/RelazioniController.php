<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Preventivo;
use App\Relazione;
use App\Utility;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelazioniController extends AdminController
{

    public function creaDaPreventivo(Request $request, $preventivo_id)
      {
      $preventivo = Preventivo::find($preventivo_id);
      $relazione = new Relazione;

      $relazione->preventivo_id = $preventivo_id;
      $relazione->associazione_id = $preventivo->associazione_id;
      $relazione->dalle = $preventivo->dalle;
      $relazione->alle = $preventivo->alle;
      $relazione->save();
      $relazione->volontari()->sync($preventivo->volontari->pluck('id')->toArray());
      return redirect()->route('relazioni.edit', [$relazione->id]);
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($query_id = 0)
    {

        $export_pdf = 0;
        $export_pdf_ore = 0;
        /////////////////////////////////////////////////////////////////
        // verifico se l'url ha un paramentro "pdf" nella query string //
        /////////////////////////////////////////////////////////////////
        if($this->request->has('pdf'))
          {
          $export_pdf = 1;
          }
        elseif ($this->request->has('pdf_ore')) 
          {
          $export_pdf_ore = 1;
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

         if(!$export_pdf_ore)
          {
          // SE NON HO QUERY STRING 
          if ($this->request->fullUrl() == $this->request->url()) 
            {
            $pdf_ore_export_url = $this->request->url() .'?pdf_ore'; 
            } 
          else 
            {
            $pdf_ore_export_url = $this->request->fullUrl() .'&pdf_ore'; 
            }    
          }
        else
          {
          $pdf_ore_export_url = $this->request->fullUrl();
          }

        //////////////
        //  ricerca //
        //////////////

        $campo = "";
        $valore = "";
        $dal = "";
        $al = "";
        $associazione_id = 0;
        $assos = Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();
        $assos = ['0' => 'Seleziona...'] + $assos;

        if ($query_id > 0)
          {

          Utility::addQueryStringToRequest($query_id,$this->request);

          }

      //////////////////
      // ordinamento  //
      //////////////////    
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


        $query = Relazione::with(['associazione','volontari'])->leftjoin('tblAssociazioni', function( $join ) use ($order)
                  {
                    $join->on('tblAssociazioni.id', '=', 'tblRelazioni.associazione_id');
                  })
                  ->withTrashed()
                  ->select('tblRelazioni.*','tblAssociazioni.nome as nome_asso');



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
              $query->where($campo, 'LIKE', "%$valore%");
              }
            elseif ($campo == 'note') 
              {
              $campo = 'tblRelazioni.note';
              $query->where($campo, 'LIKE', "%$valore%");
              }
            elseif ($campo == 'rapporto') 
              {
              $campo = 'tblRelazioni.rapporto';
              $query->where($campo, 'LIKE', "%$valore%");
              }
            elseif ($campo == 'auto') 
              {
              $campo = 'tblRelazioni.auto';
              $query->where($campo, 'LIKE', "%$valore%");
              }
            elseif ($campo == 'volontario')
              {
              $relazioni = Relazione::with(['associazione', 'volontari'])->get();
              $relazioni_ids = [];
              foreach ($relazioni as $relazione) 
                {
                // devo trovare la stringa dei volontari TRA QUELLI ASSOCIATI in QUESTA RELAZIONE!!! 
                // non tra quelli nell'associazione !!!!              
                $volontari_prev = [];
                foreach ($relazione->volontari as $v) 
                  {
                  $volontari_prev[] = $v->cognome .' ' .$v->nome;
                  }
                
                $volonari_str = strtoupper(implode(',', $volontari_prev));

                if(strpos($volonari_str, strtoupper($valore)) !== false)
                  {
                  $relazioni_ids[] = $relazione->id;
                  }
                }
                $query->whereIn('tblRelazioni.id', $relazioni_ids);
              }

            if ($campo == 'tblAssociazioni.nome')
              {
              $campo = 'nome_asso';
              }

            if($campo == 'tblRelazioni.note')
              {
              $campo = 'note';
              }

            if($campo == 'tblRelazioni.rapporto')
              {
              $campo = 'rapporto';
              }

            if($campo == 'tblRelazioni.auto')
              {
              $campo = 'auto';
              }
          
            }


        if ( $this->request->filled('cerca_dal') && $this->request->filled('cerca_al') )
          {
          $dal = $this->request->get('cerca_dal');
          $al = $this->request->get('cerca_al');
          $dal_c = Carbon::createFromFormat('d/m/Y H i', $this->request->get('cerca_dal').' 0 00');
          $al_c = Carbon::createFromFormat('d/m/Y H i', $this->request->get('cerca_al').' 23 59');
          $query->where('dalle','>=',$dal_c);
          $query->where('alle','<=',$al_c);
          }

        if( $this->request->has('associazione_id') && $this->request->get('associazione_id') != 0 )
          {
          $associazione_id = $this->request->get('associazione_id');
          $query->where('tblRelazioni.associazione_id', $associazione_id);
          }


        $query->orderBy($order_by, $order);


        if($export_pdf || $export_pdf_ore)
          {
          $relazioni = $query->get();
          }
        else
          {
          $relazioni = $query->paginate(15);
          }
        

        //////////////////////////////////
        // stampa delle ore di servizio //
        //////////////////////////////////
        if ($export_pdf_ore) 
          {
          $volontari = [];
          $columns_pdf = ['Associazione','Volontario','Totale ore'];
          foreach ($relazioni as $relazione) 
            {
            foreach ($relazione->volontari as $v) 
              {
              if (array_key_exists($v->id,$volontari)) 
                {
                $volontari[$v->id]['Totale ore'] += $relazione->getHours();
                } 
              else 
                {
                $volontari[$v->id]['Associazione'] = $v->associazione->nome;
                $volontari[$v->id]['Volontario'] = $v->cognome .' ' .$v->nome;
                $volontari[$v->id]['Totale ore'] = $relazione->getHours();
                }
              } // end volontari

            } // end relazioni
            
          }




        $columns = [
            'id' => 'ID',
            'associazione' => 'Associazione',
            '' => 'Volontari',
            'dalle' => 'Data',
            'note' => 'Note',
            'rapporto' => 'Rapporto',
            'auto' => 'Auto',
        ];

        if ($order_by == 'tblAssociazioni.nome')
        {
        $order_by = "associazione";
        }


        //return view('admin.relazioni.index', compact('relazioni','assos','associazione_id','order_by','order','ordering','columns', 'campo', 'valore', 'dal', 'al', 'pdf_export_url', 'query_id'));


        if($export_pdf)
          {
          $pdf = PDF::loadView('admin.relazioni.pdf', compact('relazioni','order_by','order','ordering','columns','campo', 'valore', 'dal', 'al', 'pdf_export_url'));
          return $pdf->stream();
          }
        elseif ($export_pdf_ore) 
          {
          $pdf = PDF::loadView('admin.relazioni.pdf_ore', compact('volontari','columns_pdf'));
          return $pdf->stream();
          }
        else
          {
          return view('admin.relazioni.index', compact('relazioni','assos','associazione_id','order_by','order','ordering','columns', 'campo', 'valore', 'dal', 'al', 'pdf_export_url','pdf_ore_export_url', 'query_id'));
          }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $assos = ['0' => 'Seleziona'] + Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();
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

      $volontari_associati = $relazione->volontari->pluck('id')->toArray();
      $assos = ['0' => 'Seleziona'] + Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();
      return view('admin.relazioni.form', compact('relazione', 'assos', 'volontari','volontari_associati'));
      
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
      $relazione = Relazione::find($id);
      // Now, when you call the delete method on the model, the deleted_at column will be set to the current date and time. 
      // And, when querying a model that uses soft deletes, the soft deleted models will automatically be excluded from all query results.
      $relazione->delete();
      return redirect('admin/relazioni')->with('status', 'Relazione eliminata!');
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


        return view('admin.relazioni.inc_volontari_select', compact('volontari','volontari_associati'));
        }
      }


    public function search()
      {

      if ( 
          ($this->request->has('search') && $this->request->filled('q')) ||  
          ($this->request->has('cerca_dal') && $this->request->filled('cerca_al')) ||
          ($this->request->has('associazione_id') && $this->request->get('associazione_id') != 0)
         )
        {
        $query_id = Utility::createQueryStringSearch($this->request);
        return redirect("admin/relazioni/$query_id");
        }
      else
        {
        return redirect("admin/relazioni");
        }

      }
}
