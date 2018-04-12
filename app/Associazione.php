<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associazione extends Model
	{
	protected $table = 'tblAssociazioni';

	protected $guarded = ['id','user_id'];




	public function volontari()
		{
			return $this->hasMany('App\Volontario','associazione_id','id')->orderBy('cognome');;
		}


	public function preventivi()
		{
			return $this->hasMany('App\Preventivo','associazione_id','id');
		}

	public function relazioni()
		{
			return $this->hasMany('App\Relazione','associazione_id','id');
		}

	public function utente()
		{
			return $this->belongsTo('App\User','user_id','id');
		}



	public function getVolontariFullName()
		{
    $volontari = [];
		foreach (self::volontari()->get() as $v) 
		  {
		  $volontari[$v->id] = $v->cognome .' ' .$v->nome;
		  }
		return $volontari;
		}

	}	
