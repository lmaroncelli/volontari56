<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{

 	protected $table = 'tblDocumenti';

 	protected $guarded = ['id','user_id'];


	public function pubblicatore()
		{
			return $this->belongsTo('App\User','user_id','id');
		}


}
