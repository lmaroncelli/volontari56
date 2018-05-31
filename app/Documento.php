<?php

namespace App;

use App\Scopes\DocumentiOwnedByScope;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{

 	protected $table = 'tblDocumenti';

 	protected $guarded = ['id','user_id'];


 	/**
 	 * The "booting" method of the model.
 	 *
 	 * @return void
 	 */

	public function pubblicatore()
		{
			return $this->belongsTo('App\User','user_id','id');
		}

  public function associazioni()
    {
    return $this->belongsToMany('App\Associazione', 'tblAssociazioniDocumenti', 'documento_id', 'associazione_id');
    }


}
