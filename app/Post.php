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


}
