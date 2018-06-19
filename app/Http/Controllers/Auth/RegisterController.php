<?php

namespace App\Http\Controllers\Auth;

use App\Associazione;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModificaUtenteRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('auth');
    }

    
    public function editaUtente($utente_id)
    {
        $utente = User::find($utente_id);

        return view('auth.edita_utente', compact('utente'));
    }


    public function modificaUtente(ModificaUtenteRequest $request, $utente_id)
      {
        $utente = User::find($utente_id);

        if ($utente->hasRole('admin') && $request->filled('name')) 
          {
          $utente->name = $request->get('name');
          }

        $utente->email = $request->get('email');
        $utente->username = $request->get('username');

        if ($request->filled('password')) 
          {
          $utente->password = Hash::make($request->get('password'));
          }

        $utente->save();

        return redirect('admin/utenti')->with('status', 'Utente \''.$utente->name.'\' modificato correttamente!');

      }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],
        [
        'name.required' => 'Il nome è obbligatorio',
        'username.required' => 'Lo username è obbligatorio',
        'username.unique' => 'Lo username è già utilizzato',
        'username.max' => 'Lo username deve essere al massimo :max caratteri',

        'email.required' => 'La mail è obbligatoria',
        'email.unique' => 'La mail è già utilizzata',
        
        'password.required' => 'La password è obbligatoria',
        'password.min' => 'Le password deve essere almeno :min caratteri',
        'password.confirmed' => 'Le password non coincidono',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'ruolo' => $data['ruolo'],
            'name' => $data['name'],
            'username' => $data['username'], 
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($data['ruolo'] == 'associazione') 
          {
          Associazione::create([
                                'nome' => $data['name'],
                                'user_id' => $user->id,
                                ]);
          }

        return $user;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect('admin/home')->with('status', 'Utente \''.$user->name.'\' creato correttamente!');


    }




    public function elencoUtenti()
    {

        /////////////////
        // ordinamento //
        /////////////////
        $order_by='name';
        $order = 'asc';
        $ordering = 0;

       $query = User::select('id','name','username','ruolo');

       $query->orderBy($order_by, $order);

       $utenti = $query->paginate(15);

       $columns = [
               'name' => 'Nome',
               'username' => 'Username',
               'ruolo' => 'Ruolo',
       ];
       
       return view('auth.elenco_utenti', compact('utenti', 'columns', 'order_by', 'order', 'ordering') ); 
    }


    public function destroyUtente($utente_id)
    {
    dd('destroyUtente id = '.$utente_id);    
    }


}
