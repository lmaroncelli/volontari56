<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{

	use SoftDeletes;


 	protected $table = 'tblPosts';

 	protected $guarded = ['id','user_id'];

	protected $dates = ['deleted_at'];


	public function autore()
		{
			return $this->belongsTo('App\User','user_id','id');
		}


	public function associazioni()
	  {
	  return $this->belongsToMany('App\Associazione', 'tblAssociazioniPosts', 'post_id', 'associazione_id');
	  }





	public function getExcerpt($len = 20)
		{
		$testo_txt = strip_tags($this->testo);

		if (strlen($testo_txt) > $len) {
			return str_limit(strip_tags($this->testo), 20, ' (...)');
		} else {
			return $testo_txt;
		}
		
		}


	public function scopeFeatured($query)
	  {
	  return $query->where('featured',1);
	  }


	 /**
	  * 
	  * @return [array]         [description]
	  */
	 public static function ownedByAssoc($current_user)
	 	{
	 		$available_ids = [];

	 		if($current_user->hasRole('associazione')) 
	 		  {

	 		  foreach (self::all() as $post) 
	 		    {
	 		    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 		    // anche se nella tabella di associazione c'è il record con associazione_id = 0, la relazione mi da [] perché NON ESISTE un'associazione con id = 0 //
	 		    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 		    $associazioni_ids = $post->associazioni->pluck('id')->toArray();
	 		    if (empty($associazioni_ids) || in_array($current_user->associazione->id,$associazioni_ids)) 
	 		      {
	 		      $available_ids[] = $post->id;
	 		      }
	 		    }
	 		   
	 		  }
	 			

	 		return $available_ids;

	 	}


}
