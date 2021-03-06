<?php

namespace App;

use App\Notifications\MyResetPasswordNotification;
use App\Volontario;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'ruolo', 'name', 'email', 'password', 'username', 'login_capabilities'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function hasRole($role)
      {
      if (is_array($role)) 
        {
        foreach ($role as $r) 
          {
          if(strtolower($r) === strtolower($this->ruolo))
            return true;
          }
        } 
      else 
        {
        return strtolower($role) === strtolower($this->ruolo);
        }
      }



    public function getAuthIdentifierName()
    {
        return 'username';
    }




    public function volontario()
      { 
          // the Volontario model is automatically assumed to have a user_id foreign key
          return $this->hasOne('App\Volontario','user_id','id');
      }


    public function posts()
      { 
          return $this->hasMany('App\Post','user_id','id');
      }

    public function documenti()
      { 
          return $this->hasMany('App\Documento','user_id','id');
      }





    public function scopeWithRole($query, $role)
      {
          return $query->where('ruolo', $role);
      }





    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPasswordNotification($token, $this->username));
    }



    /**
     * [hasLoginCapabilites definisce se un utente può fare login n base al boolean login_capabilities MA l'admin può FARE SEMPRE LOGIN]
     */
    public function hasLoginCapabilites()
      {
      return $this->ruolo == 'admin' || $this->login_capabilities;
      }



}
