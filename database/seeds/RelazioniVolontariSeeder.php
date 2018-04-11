<?php

use Illuminate\Database\Seeder;

class RelazioniVolontariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $old_relazioni_volontari  = DB::connection('old')->table('relazionivolontaris')->get();

	     $new_relazioni_volontari = [];

	      foreach ($old_relazioni_volontari as $old_rv) 
	       	{
	       	$pv['relazione_id'] = $old_rv->relazioniId;
	       	$pv['volontario_id'] = $old_rv->volontariId;

	       	$new_relazioni_volontari[] = $pv;
	       	}

	      DB::connection('mysql')->table('tblRelazioniVolontari')->truncate();
	      DB::connection('mysql')->table('tblRelazioniVolontari')->insert($new_relazioni_volontari);
    }
}
