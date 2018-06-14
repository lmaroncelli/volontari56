<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\PreventivoRequest;
use App\Preventivo;
use App\Utility;
use App\Volontario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Spatie\Geocoder\Facades\Geocoder;

class PreventiviController extends AdminController
{


    public function _savePreventivo(&$preventivo, $request)
      {
        $dalle = $request->get('data'). ' ' . $request->get('dal');
        $alle = $request->get('data'). ' ' . $request->get('al');
        $preventivo->associazione_id = $request->get('associazione_id');
        $preventivo->dalle = Utility::getCarbonDateTime($dalle);
        $preventivo->alle = Utility::getCarbonDateTime($alle);
        $preventivo->localita = $request->get('localita');
        $preventivo->motivazioni = $request->get('motivazioni');
        $preventivo->save();
        $preventivo->volontari()->sync($request->get('volontari'));
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
        
        
        //////////////
        //  ricerca //
        //////////////
        
        $campo = "";
        $valore = "";
        $dal = "";
        $al = "";
        $associazione_id = 0;
        $assos = Associazione::getForSelect();
        $no_eliminati = 0;
        $anno_filtro = date("Y");


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
        $restore_scaduto = 0;

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
        elseif ($order_by == 'scaduto') 
          {
          $order_by = "dalle";
          $restore_scaduto = 1;
          }
        elseif ($order_by == 'rel') 
          {
          $order_by = 'tblRelazioni.id';
          }


        $query = Preventivo::with(['associazione','relazione'])
                  ->leftjoin('tblAssociazioni', function( $join )
                  {
                    $join->on('tblAssociazioni.id', '=', 'tblPreventivi.associazione_id');
                  })
                  ->leftjoin('tblRelazioni', function( $join )
                  {
                    $join->on('tblRelazioni.preventivo_id', '=', 'tblPreventivi.id')
                    ->whereNull('tblRelazioni.deleted_at');
                  })
                  ->select('tblPreventivi.*','tblAssociazioni.nome as nome_asso', 'tblRelazioni.id as relazione_id');


        /////////////
        // ricerca //
        /////////////
        if ( $this->request->has('ricerca_campo') && $this->request->filled('q') )
          {

          $campo = $this->request->get('ricerca_campo');
          $valore = $this->request->get('q');

          if ($campo == 'id') 
            {
            $query->where('tblPreventivi.id','=', $valore);

            $filtro_pdf[] =  "Preventivo ID " .$valore;
            }
          elseif ($campo == 'nome_asso')
            {
            $campo = 'tblAssociazioni.nome';
            $query->where($campo, 'LIKE', "%$valore%");

            $filtro_pdf[] =  "Associazione contiene " .$valore;
            }
          elseif ($campo == 'localita') 
            {
            $campo = 'tblPreventivi.localita';
            $query->where($campo, 'LIKE', "%$valore%");

            $filtro_pdf[] =  "Località contiene " .$valore;
            }
          elseif ($campo == 'volontario')
            {
            $preventivi = Preventivo::with(['associazione', 'volontari'])->get();
            $preventivo_ids = [];
            foreach ($preventivi as $preventivo) 
              {
              // devo trovare la stringa dei volontari TRA QUELLI ASSOCIATI in QUESTO PREVENTIVO!!! 
              // non tra quelli nell'associazione !!!!              
              $volontari_prev = [];
              foreach ($preventivo->volontari as $v) 
                {
                $volontari_prev[] = $v->cognome .' ' .$v->nome;
                }
              
              $volonari_str = strtoupper(implode(',', $volontari_prev));

              if(strpos($volonari_str, strtoupper($valore)) !== false)
                {
                $preventivo_ids[] = $preventivo->id;
                }
              }
              $query->whereIn('tblPreventivi.id', $preventivo_ids);
              
              $filtro_pdf[] =  "Elenco volonari contiene " .$valore;
            }
          
          if ($campo == 'tblAssociazioni.nome')
            {
            $campo = 'nome_asso';
            }

          if($campo == 'tblPreventivi.localita')
            {
            $campo = 'localita';
            }
        
          }

        /////////////////////////////////////////////////
        // SE CERCO PER ID NON METTO GLI ALTRI VINCOLI //
        /////////////////////////////////////////////////
        if ($campo != 'id')
        { 
        if( $this->request->has('associazione_id') && $this->request->get('associazione_id') != 0 )
          {
          $associazione_id = $this->request->get('associazione_id');
          $query->where('tblPreventivi.associazione_id', $associazione_id);

          $filtro_pdf[] =  "Associazione " . Associazione::find($associazione_id)->nome;
          }

        if ( $this->request->filled('cerca_dal') && $this->request->filled('cerca_al') )
          {
          $dal = $this->request->get('cerca_dal');
          $al = $this->request->get('cerca_al');
          $dal_c = Carbon::createFromFormat('d/m/Y H i', $this->request->get('cerca_dal').' 0 00');
          $al_c = Carbon::createFromFormat('d/m/Y H i', $this->request->get('cerca_al').' 23 59');
          $query->where('tblPreventivi.dalle','>=',$dal_c);
          $query->where('tblPreventivi.alle','<=',$al_c);
          
          $filtro_pdf[] =  "Preventivi con data dal $dal al $al";
          }
        elseif($this->request->filled('anno_filtro'))
          {
          $dal_c = Carbon::createFromFormat('d/m/Y H i', '01/01/'. $this->request->get('anno_filtro') .' 0 00');
          $al_c = Carbon::createFromFormat('d/m/Y H i', '31/12/'. $this->request->get('anno_filtro') .' 23 59');
          $query->where('tblPreventivi.dalle','>=',$dal_c);
          $query->where('tblPreventivi.alle','<=',$al_c);
          
          $filtro_pdf[] =  "Preventivi anno ".$this->request->get('anno_filtro');  

          $anno_filtro = $this->request->get('anno_filtro');
          }
        else
          {
          $dal_c = Carbon::createFromFormat('d/m/Y H i', '01/01/'. $anno_filtro.' 0 00');
          $al_c = Carbon::createFromFormat('d/m/Y H i', '31/12/'. $anno_filtro.' 23 59');
          $query->where('tblPreventivi.dalle','>=',$dal_c);
          $query->where('tblPreventivi.alle','<=',$al_c);
          
          $filtro_pdf[] =  "Preventivi anno corrente";
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
        }


        $query->orderBy($order_by, $order);

        if($export_pdf)
          {
          $preventivi = $query->get();
          }
        else
          {
          $preventivi = $query->paginate(15);
          }


        $columns = [
            'scaduto' => 'Chiudere entro',
            'id' => 'ID',
            'associazione' => 'Associazione',
            '' => 'Volontari',
            'dalle' => 'Data',
            'localita' => 'Località',
            'motivazioni' => 'Motivazione',
            'rel' => 'Rel.'
        ];


        if ($order_by == 'tblAssociazioni.nome')
          {
          $order_by = "associazione";
          }
        elseif ($order_by == 'dalle' && $restore_scaduto) 
          {
          $order_by = "scaduto";
          }
        elseif ($order_by == 'tblRelazioni.id') 
          {
          $order_by = "rel";
          }


        if($export_pdf)
          {
          $filtro_pdf[] =  "<b>N° preventivi " .$preventivi->count()."</b>";
          $chunked_element = 5;
          $pdf = PDF::loadView('admin.preventivi.pdf', compact('preventivi','chunked_element','columns','filtro_pdf'));

          if($this->request->get('pdf') == 'l')
            {
            $pdf->setPaper('a4', 'landscape');
            }
            
          return $pdf->stream();
          }
        else
          {
          $limit_for_export = 500;
          return view('admin.preventivi.index', compact('preventivi','assos', 'associazione_id', 'order_by','order','ordering','columns','campo', 'valore', 'dal', 'al', 'anno_filtro', 'no_eliminati', 'pdf_export_url','query_id', 'limit_for_export'));
          }

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $assos = Associazione::getForSelect();
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
    public function store(PreventivoRequest $request)
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
     * Apre il preventivo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apri($id)
    {
    $preventivo = Preventivo::withTrashed()->find($id);
    $preventivo->aperto = Carbon::today();
    $preventivo->save();

    return redirect('admin/preventivi')->with('status', 'Preventivo ID '. $id .' riaperto correttamente!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $preventivo = Preventivo::withTrashed()->find($id);
        $volontari = $preventivo->associazione()->first()->getVolontariFullName();
        
        $volontari_associati = $preventivo->volontari->pluck('id')->toArray();
        $assos = Associazione::getForSelect();
        return view('admin.preventivi.form', compact('preventivo', 'assos', 'volontari','volontari_associati'));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PreventivoRequest $request, $id)
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
        $preventivo = Preventivo::find($id);
        // Now, when you call the delete method on the model, the deleted_at column will be set to the current date and time. 
        // And, when querying a model that uses soft deletes, the soft deleted models will automatically be excluded from all query results.
        $preventivo->delete();
        return redirect('admin/preventivi')->with('status', 'Preventivo eliminato!');
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


    public function search()
      {
      if ( 
          ($this->request->has('search') && $this->request->filled('q')) ||  
          ($this->request->has('cerca_dal') && $this->request->filled('cerca_al')) ||
          ($this->request->has('no_eliminati') && $this->request->get('no_eliminati') == 1) ||
          ($this->request->has('associazione_id') && $this->request->get('associazione_id') != 0) ||
          $this->request->has('anno_filtro')
         )
        {
        $query_id = Utility::createQueryStringSearch($this->request);
        return redirect("admin/preventivi/$query_id");
        }
      else
        {
        return redirect("admin/preventivi");
        }
      }



    /**
     * [reverseGeocodeAjax Reverse geocoding is the process of converting geographic coordinates into a human-readable address.]
     * @return [type] [description]
     */
    public function reverseGeocodeAjax()
      {
      $rev_geocode = Geocoder::getAddressForCoordinates($this->request->get('lat'), $this->request->get('long'));

      echo $rev_geocode['formatted_address'];
      }


      /**
       * [geocodeAjax Geocoding is the process of converting addresses (like a street address) into geographic coordinates (like latitude and longitude), which you can use to place markers on a map, or position the map.]
       * @return [type] [description]
       */
     public function geocodeAjax()
      {
      $geocode = Geocoder::getCoordinatesForAddress($this->request->get('indirizzo'));
      $res = [];
      $res['lat'] = $geocode['lat'];
      $res['long'] = $geocode['lng'];
      echo json_encode($res);
      }


}
