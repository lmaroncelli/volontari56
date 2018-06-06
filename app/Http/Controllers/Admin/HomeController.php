<?php

namespace App\Http\Controllers\Admin;

use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use App\Post;
use App\Preventivo;
use Illuminate\Http\Request;

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
        //////////////////////////////
        // elenco dei POST featured //
        //////////////////////////////

        $posts = Post::featured()->orderBy('created_at', 'desc')->get();


        /////////////////////////////////////////////////////////////////////////
        // se sono ASSOCIAZIONE: elenco Preventivi che scadono oggi e/o domani //
        /////////////////////////////////////////////////////////////////////////
        
        $preventivi_arr['oggi'] = Preventivo::scadutoDaGiorni(0)->get();
        $preventivi_arr['domani'] = Preventivo::scadutoDaGiorni(1)->get();
        $preventivi_arr['dopodomani'] = Preventivo::scadutoDaGiorni(2)->get();


        ///////////////////////////////
        // ultimi documenti caricati //
        ///////////////////////////////
        $documenti = Documento::listaDocumenti($order_by = 'created_at', $order = 'desc', $paginate = 0, $limit = 2);


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
