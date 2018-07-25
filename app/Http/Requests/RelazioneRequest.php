<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelazioneRequest extends FormRequest
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
               "associazione_id" => ["integer", "min:1"],
               "volontari" => ["required"],
               "data" => ["required", "date_format:d/m/Y"],
               ];  

    return $rules;
    }



    public function messages() 
        {

        $messages =  [
                "associazione_id.min" => "Selezionare Associazione",
                "volontari.required" => "Selezionare i Volontari",
                "data.required" => "Selzionare la Data",
                "data.date_format" => "La Data deve avere il formato d/m/Y",
                ];

         return $messages;

        }
}
