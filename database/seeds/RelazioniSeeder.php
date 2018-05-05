<?php

use Illuminate\Database\Seeder;

class RelazioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $old_relazioni  = DB::connection('old')->table('relazioni')->get();

     $new_relazioni = [];

     foreach ($old_relazioni as $old_r) 
       	{
       	if ($old_r->data_relazioni == '0000-00-00 00:00:00') 
       		{
       		$p['dalle'] = null;
       		$p['alle'] = null;
       		} 
       	else 
       		{
	       	$data_relazioni = substr($old_r->data_relazioni,0,10);
	       	$dal_relazioni = substr($old_r->da_ora_relazioni,11);
	       	$al_relazioni = substr($old_r->a_ora_relazioni,11);
	       	$p['dalle'] = $data_relazioni.' '.$dal_relazioni; 
	       	$p['alle'] = $data_relazioni.' '.$al_relazioni; 
       		}
       	
       	$p['preventivo_id'] = $old_r->id_servizi; 
       	$p['associazione_id'] = $old_r->id_utenti;
       	$p['note'] = $old_r->note_relazioni; 
       	$p['rapporto'] = $old_r->rapporto_relazioni; 
       	$p['auto'] = $old_r->auto_relazioni; 

        if ($old_r->annullato_relazioni) 
          {
          $p['deleted_at'] = Carbon::now()->toDateTimeString();
          } 
        else 
          {
          $p['deleted_at'] = null;
          }

       	$new_relazioni[] = $p;
       	}

      DB::connection('mysql')->table('tblRelazioni')->truncate();
      DB::connection('mysql')->table('tblRelazioni')->insert($new_relazioni);
    }
}
