<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class RelazioniOwnedByScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {   
        if (Auth::check()) 
          {
          
          if(Auth::user()->hasRole('associazione') || Auth::user()->hasRole('Referente Associazione'))
            {
            $builder->where('tblRelazioni.associazione_id', '=', Auth::user()->volontario->associazione->id);  
            }

          // solo dove c'è lui
          if(Auth::user()->hasRole('GGV Avanzato') || Auth::user()->hasRole('GGV Semplce'))
            {
            $builder->join('tblRelazioniVolontari', 'tblRelazioni.id', '=', 'tblRelazioniVolontari.relazione_id')
                    ->where('tblRelazioniVolontari.volontario_id', '=', Auth::user()->volontario->id)
                    ->select('tblRelazioni.*');

            // https://github.com/laravel/framework/issues/4962
            // taylorotwell commented on Jul 5, 2014
            // It's because of your join the contacts.id is overwriting the documents.id because they have the same column name. Use a select clause.
            
            }

          }
    }
}