<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AssociazioneOwnedByScope implements Scope
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
          if(Auth::user()->hasRole(['associazione','Referente Associazione','GGV Avanzato','GGV Semplice']))
            {
            $builder->where('tblAssociazioni.id', Auth::user()->volontario->associazione->id);
            }
          }
    }
}