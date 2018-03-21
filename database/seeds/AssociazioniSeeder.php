<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociazioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //$old_associazioni = DB::connection('old')->table('associazioni')->select('associazioni_desc', 'id_associazioni')->distinct()->get();
    	$old_associazioni = DB::connection('old')->table('utenti')->select('nome_breve_utenti', 'id_utenti')->get();
    	$new_asso = [];

    	foreach ($old_associazioni as $old_asso) 
    		{
            //$asso['id'] = $old_asso->id_associazioni;   
    		//$asso['nome'] = $old_asso->associazioni_desc;
            $asso['id'] = $old_asso->id_utenti;   
            $asso['nome'] = $old_asso->nome_breve_utenti;
    		$new_asso[] = $asso;
    		}

    	DB::connection('mysql')->table('tblAssociazioni')->truncate();
    	DB::connection('mysql')->table('tblAssociazioni')->insert($new_asso);

        Artisan::call( 'db:seed', [
            '--class' => 'UserSeeder',
            '--force' => true
        ]);

    }
}
