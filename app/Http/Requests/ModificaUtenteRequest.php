<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificaUtenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'username' => 'required|string|max:20|unique:users,username,'.$this->get('utente_id'), 
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->get('utente_id'),
        ];

        if(!is_null($this->get('name')))
          {
          $rules["name"] = 'required|string|max:255';
          }


        if(!is_null($this->get('password')))
          {
          $rules["password"] = 'string|min:6|confirmed';
          }

        return $rules;
    }

    public function messages() 
        {

        $messages =  [
                'name.required' => 'Il nome è obbligatorio',
                'username.required' => 'Lo username è obbligatorio',
                'username.unique' => 'Lo username è già utilizzato',
                'username.max' => 'Lo username deve essere al massimo :max caratteri',

                'email.required' => 'La mail è obbligatoria',
                'email.unique' => 'La mail è già utilizzata',
                
                'password.required' => 'La password è obbligatoria',
                'password.min' => 'Le password deve essere almeno :min caratteri',
                'password.confirmed' => 'Le password non coincidono',
                ];

         return $messages;

        }
}