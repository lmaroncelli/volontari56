<?php

namespace App;

use App\Scopes\RelazioniOwnedByScope;
use Illuminate\Database\Eloquent\Model;

class Relazione extends Model
{
    protected $table = 'tblRelazioni';

    protected $guarded = ['id'];

    protected $dates = ['dalle','alle'];



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RelazioniOwnedByScope);
    }


    public function volontari()
      {
      return $this->belongsToMany('App\Volontario', 'tblRelazioniVolontari', 'relazione_id', 'volontario_id');
      }

	   public function associazione()
			{
				return $this->belongsTo('App\Associazione','associazione_id','id');
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


    public function getDalleAlle()
      {
      if(is_null($this->dalle) && is_null($this->alle))
        {
        return "";
        }
      
      if ($this->dalle->toDateString() == $this->alle->toDateString()) 
        {
        return $this->dalle->format('d/m/Y'). ' dalle '.$this->dalle->format('H:i').' alle '.$this->alle->format('H:i'); 
        } 
      else 
        {
        return 'dal '. $this->dalle->format('d/m/Y H:i'). ' al '.$this->alle->format('d/m/Y H:i'); 
        
        }
      
      }
			
}
