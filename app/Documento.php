<?php

namespace App;

use App\Scopes\DocumentiOwnedByScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documento extends Model
{

 	protected $table = 'tblDocumenti';

 	protected $guarded = ['id','user_id'];


 	/**
 	 * The "booting" method of the model.
 	 *
 	 * @return void
 	 */

	public function pubblicatore()
		{
			return $this->belongsTo('App\User','user_id','id');
		}

  public function associazioni()
    {
    return $this->belongsToMany('App\Associazione', 'tblAssociazioniDocumenti', 'documento_id', 'associazione_id');
    }



   /**
    * [listaDocumenti trova la lista di documenti in base all'utente loggato ed eventualmente con un limite massimo
    * utilizzata nella sezione documenti e nella dashboard]
    * @param  integer $limit [description]
    * @return [type]         [description]
    */
   public static function listaDocumenti($order_by, $order, $paginate = 15, $limit = 0)
   	{
   		if(Auth::user()->hasRole('associazione'))
   		  {
   		  $available_ids = [];

   		  foreach (self::all() as $doc) 
   		    {
   		    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   		    // anche se nella tabella di associazione c'è il record con associazione_id = 0, la relazione mi da [] perché NON ESISTE un'associazione con id = 0 //
   		    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   		    $associazioni_ids = $doc->associazioni->pluck('id')->toArray();
   		    if (empty($associazioni_ids) || in_array(Auth::user()->volontario->associazione->id,$associazioni_ids)) 
   		      {
   		      $available_ids[] = $doc->id;
   		      }
   		    }

   		   $query = self::whereIn('id',$available_ids)->orderBy($order_by, $order);
   		   
   		   if ($limit) 
   		   	{
   		  	$documenti = $query->limit($limit)->get();
   		   	} 
   		   else 
   		   	{
   		  	$documenti = $query->paginate($paginate);
   		   	}
   		   
   		  
   		  }
   		else
   		  {

   		  $query = self::orderBy($order_by, $order); 
   		  
   		  if ($limit) 
   		  	{
   		  	$documenti = $query->limit($limit)->get();
   		  	} 
   		  else 
   		  	{
   		  	$documenti = $query->paginate($paginate);
   		  	}
   		  
   		  
   		  }

   		return $documenti;

   	}


}
