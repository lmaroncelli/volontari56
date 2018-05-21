<?php

namespace App;

use App\Scopes\PreventiviOwnedByScope;
use App\Scopes\SoftDeletedScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Preventivo extends Model
{

    use SoftDeletes;
    

    protected $table = 'tblPreventivi';

    protected $guarded = ['id'];

    protected $dates = ['dalle','alle','deleted_at'];



    const GG_VALIDO = 30;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new SoftDeletedScope);
        static::addGlobalScope(new PreventiviOwnedByScope);
    }


    public function volontari()
      {
      return $this->belongsToMany('App\Volontario', 'tblPreventiviVolontari', 'preventivo_id', 'volontario_id');
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


    /**
     * [isInTime ENTRO 30 gg dalla data del preventivo POSSO CREARE IL SERVIZIO (bottone verde)
     * Dopo 30 gg il bottone verde è disabilitato]
     * @return boolean [description]
     */
    public function isInTime()
      {

      // oggi-creazione <= 30 
      // oggi <= 30+creazione
      $creazione_plus_delay = $this->dalle->addDays(self::GG_VALIDO);
      return Carbon::today()->lte($creazione_plus_delay);
    
      }


    public function displayInTime()
      {

      // oggi-creazione <= 30 
      // oggi <= 30+creazione
      
      // dalla data di creazione tolgo ore/minuti e secondi
      $data_dalle = Carbon::createFromFormat('Y-m-d',$this->dalle->toDateString());
      
      $creazione_plus_delay = $data_dalle->addDays(self::GG_VALIDO);
      

      $gg_mancanti = Carbon::today()->diffInDays($creazione_plus_delay, false);


      if($gg_mancanti > 1)
        {
        return $gg_mancanti . " giorni"; 
        }
      if($gg_mancanti == 1)
        {
        return "domani";
        }
      elseif ($gg_mancanti == 0) 
        {
        return "oggi";
        }
      elseif($gg_mancanti == -1)
        {
        return abs($gg_mancanti)." giorno fa";
        }
      else
        {
        return abs($gg_mancanti)." giorni fa";
        }

      }
			
}
