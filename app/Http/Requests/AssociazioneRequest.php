<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssociazioneRequest extends FormRequest
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
               "nome" => ["required"],
               ];  

       return $rules;

       }

   public function messages() 
       {

       $messages =  [
               "nome.required" => "Il campo nome è obbligatorio",
               ];

        return $messages;

       }
}
