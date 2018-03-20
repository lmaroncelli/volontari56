<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'ruolo', 'name', 'email', 'password', 'username'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function getAuthIdentifierName()
    {
        return 'username';
    }




    public function associazione()
      { 
          // the Associazione model is automatically assumed to have a user_id foreign key
          return $this->hasOne('App\Associazione','user_id','id');
      }

}
