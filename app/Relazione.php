<?php

namespace App;

use App\Preventivo;
use App\Scopes\RelazioniOwnedByScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relazione extends Model
{

    use SoftDeletes;

    
    protected $table = 'tblRelazioni';

    protected $guarded = ['id'];

    protected $dates = ['dalle','alle','deleted_at'];



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



    public function preventivo()
     {
         return $this->belongsTo('App\Preventivo','preventivo_id','id');
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


    public function getHours()
      {
      /* ATTENZIONE SE ALLE è 00:00 */
      if ($this->alle->toTimeString() == '00:00:00') 
        {
        //aggiungo un giorno in modo che 00:00::00 sia mezzanotte cioè lo 0 del gg dopo
        //
        return $this->dalle->diffInHours($this->alle->addDay(1));
        } 
      else 
        {
        return $this->dalle->diffInHours($this->alle);
        }
      }
			
}
