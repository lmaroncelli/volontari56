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
    	
    	$volontari = Volontario::all();
    	$new_users = [];
    	foreach ($volontari as $volontario) 
    		{
    		$nu['name'] = ucfirst(strtolower($volontario->nome)) . ' ' . ucfirst(strtolower($volontario->cognome));
    		$nu['username'] = strtolower($volontario->nome).'_'.strtolower($volontario->cognome).'_'.$volontario->associazione_id;
    		$nu['password'] = bcrypt(strtolower($volontario->nome).'_'.strtolower($volontario->cognome));
    		$new_users[] = $nu;
    		}

    	User::create($new_users);

    }
}
