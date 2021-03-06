<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\DocumentoRequest;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentiController extends AdminController
{

   public function __construct(Request $request)
     {
       $this->middleware('forbiddenIfRole:GGV Avanzato')->only(['formUpload','modifica','upload','aggiorna','elimina']);
       $this->middleware('forbiddenIfRole:GGV Semplice')->only(['formUpload','modifica','upload','aggiorna','elimina']);

       // Invoke parent
       parent::__construct($request);
     }

  public function formUpload()
    {
    $doc = new Documento;

    $associazioni_associate = ['0' => 'Tutte'];
   
    $assos = Utility::getAssociazioni();
   

    return view('admin.documenti.form', compact('doc','associazioni_associate','assos'));
  	}


  public function modifica($documento_id = 0)
    {
    $doc = Documento::find($documento_id);
    
    $associazioni_associate = $doc->associazioni->pluck('id','nome')->toArray();
    if(!count($associazioni_associate))
      {
      $associazioni_associate = ['0' => 'Tutte'];
      }
    else
      {
      if(array_key_exists(0, $associazioni_associate))
        {
          unset($associazioni_associate[0]);
        }
      }
    $assos = Utility::getAssociazioni();

    return view('admin.documenti.form', compact('doc','associazioni_associate','assos'));
    }

  public function upload(DocumentoRequest $request)
    {

      $doc_array = $request->except(['fileToUpload','associazioni']);
      $ext = $request->fileToUpload->getClientOriginalExtension();
      $doc_array['ext'] = $ext;
      $fileName = time()."_".$request->fileToUpload->getClientOriginalName(); 
      $request->fileToUpload->storeAs('public',$fileName);

      $doc_array['file'] = $fileName;

      $doc = Documento::create($doc_array);

      $associazioni = is_null($request->get('associazioni')) ? 0 : $request->get('associazioni');
      $doc->associazioni()->sync($associazioni);


      return redirect('admin/documenti')->with('status', 'Documento creato correttamente!');

    }

  public function aggiorna(DocumentoRequest $request, $documento_id = 0)
    {
    $doc = Documento::find($documento_id);
    $doc->update($request->except('associazioni'));
    
    $associazioni = is_null($request->get('associazioni')) ? 0 : $request->get('associazioni');
    $doc->associazioni()->sync($associazioni);

    return redirect('admin/documenti')->with('status', 'Documento modificato correttamente!');
    }

  public function index()
    {

      //////////////////
      // ordinamento  //
      //////////////////
      $order_by='created_at';
      $order = 'desc';
      $ordering = 0;


      if ($this->request->filled('order_by'))
        {
        $order_by=$this->request->get('order_by');
        $order = $this->request->get('order');
        $ordering = 1;
        }

      $columns = [
          'titolo' => 'Titolo',
          'argomento' => 'Argomento',
          'tipo' => 'Tipo',
          'created_at' => 'Caricato il'
      ];
  

    $documenti = Documento::listaDocumenti($order_by, $order, $paginate = 15, $limit = 0);

    return view('admin.documenti.index', compact('documenti', 'order_by','order','ordering','columns') );
    }


  public function elimina($documento_id)
  {   
      $documento = Documento::find($documento_id);
      $file = $documento->file;
      $documento->delete();

      Storage::delete('public/'.$file);

      return redirect('admin/documenti')->with('status', 'Documento eliminato!');
  }


}
