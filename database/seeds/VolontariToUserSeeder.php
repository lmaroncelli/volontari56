<?php

use App\User;
use App\Volontario;
use Illuminate\Database\Seeder;

class VolontariToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$volontari = Volontario::where('nota', '!=' , "GENERICO")->get();
    	$new_users = [];
    	foreach ($volontari as $key => $volontario) 
    		{
    		$nu = [];
    		$nu['name'] = ucfirst(strtolower($volontario->nome)) . ' ' . ucfirst(strtolower($volontario->cognome));
    		$nu['email'] = 'user_da_volontario@gmail.com';
    		$nu['username'] = strtolower($volontario->nome).'_'.strtolower($volontario->cognome).'_'.$volontario->associazione_id.'_'.$key;
    		$nu['password'] = bcrypt(strtolower($volontario->nome).'_'.strtolower($volontario->cognome));
    		$user = User::create($nu);
    		$volontario->user_id = $user->id;
    		$volontario->save();
    		}
    

    }
}
