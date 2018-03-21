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

			
}
