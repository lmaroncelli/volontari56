<?php

use Illuminate\Database\Seeder;

class PreventiviVolontariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $old_preventivi_volontari  = DB::connection('old')->table('servizivolontaris')->get();

	     $new_preventivi_volontari = [];

	      foreach ($old_preventivi_volontari as $old_pv) 
	       	{
	       	$pv['preventivo_id'] = $old_pv->serviziId;
	       	$pv['volontario_id'] = $old_pv->volontariId;

	       	$new_preventivi_volontari[] = $pv;
	       	}

	      DB::connection('mysql')->table('tblPreventiviVolontari')->truncate();
	      DB::connection('mysql')->table('tblPreventiviVolontari')->insert($new_preventivi_volontari);
    }
}
