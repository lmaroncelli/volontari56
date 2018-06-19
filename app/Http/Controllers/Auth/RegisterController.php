<?php

namespace App\Http\Controllers\Auth;

use App\Associazione;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


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

}
