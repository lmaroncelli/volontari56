<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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


}
