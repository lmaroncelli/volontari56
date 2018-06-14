<?php

namespace App;

use App\Relazione;
use App\Scopes\PreventiviOwnedByScope;
use App\Scopes\SoftDeletedScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Preventivo extends Model
{

    use SoftDeletes;
    

    protected $table = 'tblPreventivi';

    protected $guarded = ['id'];

    protected $dates = ['dalle','alle','aperto','deleted_at'];



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


    public function relazione()
    {
        return $this->hasOne('App\Relazione','preventivo_id','id');
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

      if (self::isAperto()) 
        {
        return true;
        }

      // oggi-creazione <= 30 
      // oggi <= 30+creazione
      $creazione_plus_delay = $this->dalle->addDays(self::GG_VALIDO);
      return Carbon::today()->lte($creazione_plus_delay);
    
      }


    /**
     * [isAperto è aperto se c'è una data nella colonna "aperto" e QUINDI NON E' NULLA (default)]
     * @return boolean [description]
     */
    public function isAperto()
      {
      return !is_null($this->aperto); 
      }


    public function displayInTime()
      {

      if (self::isAperto()) 
        {
        return '<button type="button" class="btn bg-navy btn-flat">Riaperto</button>';
        }

      // oggi-creazione <= 30 
      // oggi <= 30+creazione
      
      // dalla data di creazione tolgo ore/minuti e secondi
      list($day, $month, $year) = explode('/', $this->dalle->format('d/m/Y'));

      $data_dalle = Carbon::create($year, $month, $day, 0, 0, 0);
      
      $creazione_plus_delay = $data_dalle->addDays(self::GG_VALIDO);
      

      $gg_mancanti = Carbon::today()->diffInDays($creazione_plus_delay, false);


      if($gg_mancanti > 1)
        {
        return $gg_mancanti . " giorni"; 
        }
      if($gg_mancanti == 1)
        {
        return "<span class='domani'>domani</span>";
        }
      elseif ($gg_mancanti == 0) 
        {
        return "<span class='oggi'>oggi</span>";
        }
      elseif($gg_mancanti == -1)
        {
        return '<span class="red1">'. abs($gg_mancanti)." giorno fa </span>";
        }
      else
        {
        return '<span class="red2">'. abs($gg_mancanti)." giorni fa </span>";
        }

      }


    public function scopeScadutoDaGiorni($query, $gg = 0)
      {
      /*
      SQL: CHE SCADONO IERI
      SELECT p.* FROM `tblPreventivi` p
      WHERE DATE_ADD(date_format(p.dalle,'%Y-%m-%d'),INTERVAL 30 DAY) = DATE_SUB(DATE(NOW()), INTERVAL 1 DAY )

      SQL: CHE SCADONO OGGI
      SELECT p.* FROM `tblPreventivi` p
      WHERE DATE_ADD(date_format(p.dalle,'%Y-%m-%d'),INTERVAL 30 DAY) = DATE_SUB(DATE(NOW()), INTERVAL 0 DAY ) 
       
      SQL: CHE SCADONO DOMANI
      SELECT p.* FROM `tblPreventivi` p
      WHERE DATE_ADD(date_format(p.dalle,'%Y-%m-%d'),INTERVAL 30 DAY) = DATE_SUB(DATE(NOW()), INTERVAL -1 DAY )
       */
      
      /**
       *
       * dalle + 30gg = oggi -1
       * dalle = oggi -1 -30
       * 
       */
      
     
      $gg_total = $gg - self::GG_VALIDO; 

     return $query->whereNotNull('dalle')->where(DB::raw("date_format(dalle,'%Y-%m-%d')"), '=', Carbon::today()->addDays($gg_total)->toDateString() );


      }
			
}
