<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class PreventiviOwnedByScope implements Scope
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
          if(Auth::user()->hasRole('associazione'))
            {
            $builder->where('tblPreventivi.associazione_id', '=', Auth::user()->volontario->associazione->id);  
            }
          }
    }
}