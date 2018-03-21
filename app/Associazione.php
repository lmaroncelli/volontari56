<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associazione extends Model
	{
	protected $table = 'tblAssociazioni';

	protected $guarded = ['id','user_id'];




	public function volontari()
		{
			return $this->hasMany('App\Volontario','associazione_id','id');
		}


	public function preventivi()
		{
			return $this->hasMany('App\Preventivo','associazione_id','id');
		}

	public function utente()
		{
			return $this->belongsTo('App\User','user_id','id');
		}


	}	
