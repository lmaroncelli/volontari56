<?php

namespace App\Http\Controllers\Admin;

use App\Associazione;
use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\DocumentoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentiController extends AdminController
{


  private function _getAssociazioni(&$assos)
    {
    $assos = ['0' => 'Tutte'] + Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();
    }

  public function formUpload()
    {
    $doc = new Documento;

    $associazioni_associate = ['0' => 'Tutte'];
    $assos = null;
    $this->_getAssociazioni($assos);
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
    $assos = null;
    $this->_getAssociazioni($assos);

    return view('admin.documenti.form', compact('doc','associazioni_associate','assos'));
    }

  public function upload(DocumentoRequest $request)
    {

      $doc_array = $request->except(['fileToUpload','associazioni']);
      $ext = request()->fileToUpload->clientExtension();
      $doc_array['ext'] = $ext;
      $fileName = "file_".time().'.'.$ext; 
      $request->fileToUpload->storeAs('documenti',$fileName);

      $doc_array['file'] = $fileName;
      $doc = Documento::create($doc_array);
      $doc->associazioni()->sync($request->get('associazioni'));


      return redirect('admin/documenti')->with('status', 'Documento creato correttamente!');

    }

  public function aggiorna(DocumentoRequest $request, $documento_id = 0)
    {
    $doc = Documento::find($documento_id);
    $doc->update($request->except('associazioni'));
    $doc->associazioni()->sync($request->get('associazioni'));

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
    
    $available_ids = [];

    if(Auth::user()->hasRole('associazione'))
      {

      foreach (Documento::all() as $doc) 
        {
        $associazioni_ids = $doc->associazioni->pluck('id')->toArray();
        if (in_array(0,$associazioni_ids) || in_array(Auth::user()->associazione()->id,$associazioni_ids)) 
          {
          $available_ids[] = $doc->id;
          }
        }    

      }
      
      if (count($available_ids)) 
        {
        $documenti = Documento::whereIn('id',$available_ids)->orderBy($order_by, $order)->paginate(15);
        } 
      else 
        {
        $documenti = Documento::orderBy($order_by, $order)->paginate(15);
        }
      
    


    return view('admin.documenti.index', compact('documenti', 'order_by','order','ordering','columns') );
    }


  public function elimina($documento_id)
  {   
      $documento = Documento::find($documento_id);
      $file = $documento->file;
      $documento->delete();

      Storage::delete('documenti/'.$file);

      return redirect('admin/documenti')->with('status', 'Documento eliminato!');
  }


}
