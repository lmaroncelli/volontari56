<?php

namespace App\Http\Controllers\Admin;

use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use App\Post;
use App\Preventivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends AdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $preventivi_arr = [];
        
        //////////////////////////////
        // elenco dei POST featured //
        //////////////////////////////

        $query = Post::featured();


        /////////////////////////////////////////////////////////
        // se sono un'ASSOCIAZIONE deveo vedere solo i miei !! //
        /////////////////////////////////////////////////////////
        if(Auth::user()->hasRole('associazione','Referente Associazione', 'GGV Avanzato', 'GGV Semplice'))
          {
          $available_ids = Post::ownedByAssoc(Auth::user()); 
          $query->whereIn('id',$available_ids);
          }
        

        $posts = $query->orderBy('created_at', 'desc')->get();


        if(!Auth::user()->hasRole('Polizia') && !Auth::user()->hasRole('GGV Semplice'))
          {

          /////////////////////////////////////////////////////////////////////////
          // se sono ASSOCIAZIONE: elenco Preventivi che scadono oggi e/o domani //
          /////////////////////////////////////////////////////////////////////////
          
          $preventivi_arr['oggi'] = Preventivo::scadutoDaGiorni(0)->get();
          $preventivi_arr['domani'] = Preventivo::scadutoDaGiorni(1)->get();
          $preventivi_arr['dopodomani'] = Preventivo::scadutoDaGiorni(2)->get();

          }


        ///////////////////////////////
        // ultimi documenti caricati //
        ///////////////////////////////
        $documenti = Documento::listaDocumenti($order_by = 'created_at', $order = 'desc', $paginate = 0, $limit = 0);


        $columns_posts = [
            'scaduto' => 'Chiudere entro',
            'id' => 'ID',
            'associazione' => 'Associazione',
            '' => 'Volontari',
            'dalle' => 'Data',
            'localita' => 'Località',
            'motivazioni' => 'Motivazione',
        ];

        $columns_docs = [
          'titolo' => 'Titolo',
          'argomento' => 'Argomento',
          'tipo' => 'Tipo',
          'created_at' => 'Caricato il'
      ];

        return view('admin.dashboard.dashboard', compact('columns_posts','preventivi_arr', 'posts','documenti','columns_docs','limit'));
    }
}
