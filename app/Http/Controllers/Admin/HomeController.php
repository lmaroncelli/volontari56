<?php

namespace App\Http\Controllers\Admin;

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

        $posts = Post::featured()->get();


        /////////////////////////////////////////////////////////////////////////
        // se sono ASSOCIAZIONE: elenco Preventivi che scadono oggi e/o domani //
        /////////////////////////////////////////////////////////////////////////

        $preventivi = Preventivo::first();



        return view('admin/dashboard');
    }
}
