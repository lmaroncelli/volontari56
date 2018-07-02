<?php

use App\Associazione;
use App\User;
use App\Volontario;
use Illuminate\Database\Seeder;

class UsersToVolontariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	$users = User::withRole('associazione')->get();

     	foreach ($users as $key => $user) 
     		{
     		$associazione = Associazione::where('nome',$user->name)->first();
     		$nv = [];
     		$nv['associazione_id'] = $associazione->id;
     		$nv['user_id'] = $user->id;
     		$nv['nome'] = $user->name;
     		$nv['cognome'] = "";
     		$nv['nota'] = "GENERICO";
     		$volontario = Volontario::create($nv);
     		}

    }
}
