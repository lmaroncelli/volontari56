<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Post;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends AdminController
{   

    function __construct(Request $request)
    {
      $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        /////////////
        // Ricerca //
        /////////////
        $no_eliminati = 0;


        /////////////////
        // ordinamento //
        /////////////////
        $order_by='titolo';
        $order = 'asc';
        $associazione_id = 0;
        $ordering = 0;



        if ($this->request->filled('order_by'))
          {
          $order_by=$this->request->get('order_by');
          $order = $this->request->get('order');
          $ordering = 1;
          }


        if ($order_by == 'autore')
          {
          $order_by = "users.name";
          }

        $query = Post::with(['autore'])->leftjoin('users', function( $join )
        {
          $join->on('users.id', '=', 'tblPosts.user_id');
        })
        ->select('tblPosts.*','users.name');

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



        /////////////////////////////////////////////////////////
        // se sono un'ASSOCIAZIONE deveo vedere solo i miei !! //
        /////////////////////////////////////////////////////////
         if(Auth::user()->hasRole('associazione'))
          {
          $available_ids = Post::ownedByAssoc(); 
          $query->whereIn('id',$available_ids);
          }


        $query->orderBy($order_by, $order);

        $posts = $query->paginate(15);

        $columns = [
                'titolo' => 'Titolo',
                'slug' => 'Slug',
                'autore' => 'Autore',
                'created_at' => 'Data di creazione',
                'updated_at' => 'Data di modifica',
                'featured' => 'Featured'
        ];

        if ($order_by == 'users.name')
          {
          $order_by = "autore";
          }

        return view('admin.posts.index', compact('posts', 'columns', 'order_by', 'order', 'ordering') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post;

        $associazioni_associate = ['0' => 'Tutte'];
        $assos = Utility::getAssociazioni();

        return view('admin.posts.form', compact('post','associazioni_associate','assos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    //dd($request->all());
    $post = Post::create($request->except('associazioni'));
    Auth::user()->posts()->save($post);

    $associazioni = is_null($request->get('associazioni')) ? 0 : $request->get('associazioni');
    $post->associazioni()->sync($associazioni);

    return redirect('admin/posts')->with('status', 'Post creato correttamente!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $post = Post::withTrashed()->find($id);

    return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $post = Post::withTrashed()->find($id);
      $associazioni_associate = $post->associazioni->pluck('id','nome')->toArray();
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

      return view('admin.posts.form', compact('post','associazioni_associate','assos'));
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
      $post = Post::find($id);
      $post->fill($request->except('associazioni'));
      $post->featured = $request->filled('featured');
      $post->save();

      $associazioni = is_null($request->get('associazioni')) ? 0 : $request->get('associazioni');
      $post->associazioni()->sync($associazioni);

      return redirect('admin/posts')->with('status', 'Post aggiornato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);
      
      // Now, when you call the delete method on the model, the deleted_at column will be set to the current date and time. 
      // And, when querying a model that uses soft deletes, the soft deleted models will automatically be excluded from all query results.
      $post->delete();
      return redirect('admin/posts')->with('status', 'Post eliminato!');
    }




    public function slugAjax()
      {
      $value = $this->request->input("value");

      echo str_slug($value,'-');
      }


    public function upload()
      {
      
      if($this->request->hasfile('file')) 
        { 
          $file = $this->request->file('file');
          $extension = $file->getClientOriginalExtension(); // getting image extension
          $filename = $file->hashName();
          $file->move('images/posts/', $filename);
          echo json_encode( array('location' => url('images/posts/'.$filename)) );
        }
      else
        {
        // Notify editor that the upload failed
        header("HTTP/1.1 500 Server Error");
        }
    
      }


}
