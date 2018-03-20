<?php
namespace App\Http\Controllers\Admin;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct()
    {
    	//$this->middleware('auth');
      //view()->share( 'signedIn', Auth::check() );
    }


      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
    		/*if (Auth::user()->ruolo == 'admin') 
          {
         	
          return view('admin.home', compact('custompages'));
    		  } 
        else 
          {
    			return redirect('/');
    		  }*/		
      }
}