<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VolontariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creo questa vista per associare ad ogni volontario l'associazione tramite il login
        // SELECT v.* , u.nome_breve_utenti FROM `volontari` v join utenti u on v.`id_volontari_utenti` = u.id_utenti order by u.nome_breve_utenti asc
    		
    		$old_volontari  = DB::connection('old')->table('volontari')
    		            ->join('utenti', 'volontari.id_volontari_utenti', '=', 'utenti.id_utenti')
    		            ->select('volontari.*', 'utenti.nome_breve_utenti')
    		            ->get();


    		$assoc = DB::connection('mysql')->table('tblAssociazioni')->select('nome','id')->get();

    		$associazioni = [];
    		
    		foreach ($assoc as $a) 
    			{
    			$associazioni[strtoupper($a->nome)] = $a->id;
    			}

    		//dd($associazioni);


    		$new_volontari = [];

    		foreach ($old_volontari as $old_v) 
    			{
    			 $v['nome'] = $old_v->nome_volontari;
					$v['cognome'] = $old_v->cognome_volontari;
					$v['nota'] = $old_v->note_volontari;
					$v['registro'] = $old_v->registro_volontari;
					
					$data_nascita = substr($old_v->natoil_volontari, 0, 10);
					if ($data_nascita == '0000-00-00') 
						{
						$v['data_nascita'] = null;
						} 
					else 
						{
						$v['data_nascita'] = $data_nascita;
						}
					
					if ( array_key_exists($old_v->nome_breve_utenti, $associazioni) ) 
						{
						 $v['associazione_id'] = $associazioni[$old_v->nome_breve_utenti];
						}
					$new_volontari[] = $v;
    			}
    		DB::connection('mysql')->table('tblVolontari')->truncate();
    		DB::connection('mysql')->table('tblVolontari')->insert($new_volontari);
    }
}
