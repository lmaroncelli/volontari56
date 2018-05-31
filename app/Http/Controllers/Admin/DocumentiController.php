<?php

namespace App\Http\Controllers\Admin;

use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\DocumentoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentiController extends AdminController
{

  public function formUpload()
  	{
  	$doc = new Documento;
  	return view('admin.documenti.form', compact('doc'));
  	}


  public function modifica($documento_id = 0)
    {
    $doc = Documento::find($documento_id);
    return view('admin.documenti.form', compact('doc'));
    }

  public function upload(DocumentoRequest $request)
    {

      $doc_array = $request->except('fileToUpload');
      $ext = request()->fileToUpload->clientExtension();
      $doc_array['ext'] = $ext;
      $fileName = "file_".time().'.'.$ext; 
      $request->fileToUpload->storeAs('documenti',$fileName);

      $doc_array['file'] = $fileName;
      $doc = Documento::create($doc_array);

      return redirect('admin/documenti')->with('status', 'Documento creato correttamente!');

    }

  public function aggiorna(DocumentoRequest $request, $documento_id = 0)
    {
    $doc = Documento::find($documento_id);
    $doc->update($request->all());

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
    
    $documenti = Documento::orderBy($order_by, $order)->paginate(15);

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
