<?php

namespace App;

use App\Scopes\AssociazioneOwnedByScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Associazione extends Model
	{
	protected $table = 'tblAssociazioni';

	protected $guarded = ['id','user_id'];



	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
	    parent::boot();

	    //static::addGlobalScope(new AssociazioneOwnedByScope);
	}



	public function scopeFiltered($query)
    {		
    	if (Auth::check()) 
    	  {
    	  if(Auth::user()->hasRole('associazione'))
    	    {
    	    return $query->where('id', Auth::user()->associazione->id);  
    	    }
    	  }
    	 else
  	 		{
        return $query;
  	 		}
    }


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


	public function documenti()
	  {
	  return $this->belongsToMany('App\Documento', 'tblAssociazioniDocumenti', 'associazione_id', 'documento_id');
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


	public static function getForSelect($select = 1) 
		{
		
		$assos = self::filtered()->orderBy('nome')->pluck('nome', 'id')->toArray();
    if($select)
    	{
    	$assos = ['0' => 'Seleziona...'] + $assos;
    	}

    return $assos;
		
		}

	}	
