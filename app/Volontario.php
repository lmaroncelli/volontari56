<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Volontario extends Model
	{
  
  protected $table = 'tblVolontari';

  protected $guarded = ['id'];

  protected $dates = ['data_nascita'];



  public function preventivi()
    {
    return $this->belongsToMany('App\Preventivo', 'tblPreventiviVolontari', 'volontario_id', 'preventivo_id');
    }


  public function setDataNascitaAttribute($value)
   	{
    if ($value == '0000-00-00') 
      {
      $this->attributes['data_nascita'] = Carbon::today();
      } 
    else 
      {
      $this->attributes['data_nascita'] = Carbon::createFromFormat('d/m/Y', $value);
      }
    
   	}

  public function getDataNascitaAttribute($value)
		{
	  return Carbon::parse($value)->format('d/m/Y');
		}


  public function associazione()
  	{
  		return $this->belongsTo('App\Associazione','associazione_id','id');
  	}


  public function getNomeAttribute($value)
    {
    return ucfirst(strtolower($value)) . ' ' . ucfirst(strtolower($this->cognome));
    }

	}
