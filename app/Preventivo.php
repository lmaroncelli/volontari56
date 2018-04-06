<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preventivo extends Model
{
    protected $table = 'tblPreventivi';

    protected $guarded = ['id'];

    protected $dates = ['dalle','alle'];


    public function volontari()
      {
      return $this->belongsToMany('App\Volontario', 'tblPreventiviVolontari', 'preventivo_id', 'volontario_id');
      }

	   public function associazione()
			{
				return $this->belongsTo('App\Associazione','associazione_id','id');
			}



    public function getVolontariLista()
      {
      foreach ($this->volontari as $v) 
        {
        $v_arr[] = $v->nome;
        }
      return implode(', ', $v_arr);
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
