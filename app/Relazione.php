<?php

namespace App;

use App\Preventivo;
use App\Scopes\RelazioniOwnedByScope;
use App\Utility;
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


    public function getMinutes()
      {

      /*
      dalle: "2018-02-14 20:00:00",
      alle: "2018-02-14 00:20:00",
       */
      if ( $this->dalle->gt($this->alle) ) 
        {
        $total_minutes =  $this->dalle->diffInMinutes($this->alle->addDay(1));
        } 
      else 
        {
        $total_minutes = $this->dalle->diffInMinutes($this->alle);
        }

      return $total_minutes;

      }


    public function getHoursForView()
      {

      /*
      dalle: "2018-02-14 20:00:00",
      alle: "2018-02-14 00:20:00",
       */
      

      $total_minutes = $this->getMinutes();

  
      return Utility::getHoursForView($total_minutes);


      }


    public function setKmAttribute($value)
      {   
        if(empty($value))
          $this->attributes['km'] = 0;
        else
          $this->attributes['km'] = abs($value);
      }


    
			
}
