<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PreventiviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $old_preventivi  = DB::connection('old')->table('servizi')->get();

       $new_preventivi = [];

       foreach ($old_preventivi as $old_p) 
	       	{
	       	if ($old_p->data_servizi == '0000-00-00 00:00:00') 
	       		{
	       		$p['dalle'] = null;
	       		$p['alle'] = null;
	       		} 
	       	else 
	       		{
		       	$data_servizi = substr($old_p->data_servizi,0,10);
		       	$dal_servizi = substr($old_p->da_ora_servizi,11);
		       	$al_servizi = substr($old_p->a_ora_servizi,11);
		       	$p['dalle'] = $data_servizi.' '.$dal_servizi; 
		       	$p['alle'] = $data_servizi.' '.$al_servizi; 
	       		}
	       	
	       	$p['localita'] = $old_p->note_servizi; 
	       	$p['motivazioni'] = $old_p->rapporto_servizi; 
	       	$p['associazione_id'] = $old_p->id_utenti;

	       	if ($old_p->annullato_servizi) 
	       		{
	       		$p['deleted_at'] = Carbon::now()->toDateTimeString();
	       		} 
	       	else 
	       		{
	       		$p['deleted_at'] = null;
	       		}
	       	

	       	$new_preventivi[] = $p;
	       	}

	      DB::connection('mysql')->table('tblPreventivi')->truncate();
	      DB::connection('mysql')->table('tblPreventivi')->insert($new_preventivi);
    }
}
