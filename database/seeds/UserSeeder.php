<?php

use App\Associazione;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $assoc = DB::connection('mysql')->table('tblAssociazioni')->select('nome','id')->get();
        $associazioni = [];
        foreach ($assoc as $a) 
          {
          $associazioni[strtoupper($a->nome)] = $a->id;
          }
        //dd($associazioni);


        $old_utenti  = DB::connection('old')->table('utenti')->get();

        $new_users = [];

        foreach ($old_utenti as $utente) 
          {
          $user['id'] =   $utente->id_utenti;
          $user['name'] = $utente->nome_utenti;
          $user['username'] = $utente->login_utenti;
          $user['password'] = bcrypt($utente->password_utenti);
          if ($utente->isadmin_utenti == 1) 
            {
            $user['ruolo'] = 'admin';
            }
          else
            {
            $user['ruolo'] = 'associazione';
            }
          if ( array_key_exists($utente->nome_utenti, $associazioni) ) 
            {
            $associazione_id = $associazioni[$utente->nome_utenti];
            $asso = Associazione::find($associazione_id);
            $asso->user_id = $utente->id_utenti;
            $asso->save();
            }
          $new_users[] = $user;
          }


      DB::connection('mysql')->table('users')->truncate();
      DB::connection('mysql')->table('users')->insert($new_users);



    	DB::table('users')->insert([
                    'ruolo' => "admin",
                    'name' => "Luigi Maroncelli",
                    'email' => 'lmaroncelli@gmail.com',
                    'username' => 'lmaroncelli',
                    'password' => bcrypt('Labietta')
    	       ]);


    }
}
