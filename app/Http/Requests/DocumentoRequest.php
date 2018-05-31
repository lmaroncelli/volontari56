<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
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

        $rules =  
            [
            'titolo' => 'required',
            'argomento' => 'required',
            ];

        if($this->has('fileToUpload'))
          {
          $rules =  
              [
              'fileToUpload' => 'required|max:2048',
              ];
          }

        return $rules;
    }

    public function messages() 
        {

        $messages = 
            [
            'titolo.required' => 'Inserire un titolo',
            'argomento.required' => 'Inserire un argomento',
            ];

        if($this->has('fileToUpload'))
          {
          $messages = 
              [
              "fileToUpload.max" => "Il file da caricare è troppo grande"
              ];
          } 

         return $messages;

        }
}
