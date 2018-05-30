<?php

namespace App\Http\Controllers\Admin;

use App\Documento;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class DocumentiController extends AdminController
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



  public function formUpload()
  	{
  	$doc = new Documento;
  	return view('admin.documenti.form', compact('doc'));
  	}


}
