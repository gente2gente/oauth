<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JsonRequest extends FormRequest
{
    /**
     * The data to be validated should be processed as JSON.
     * @return mixed
     */
    /*protected function validationData()
    {
        return $this->json()->all();
    }*/


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
        return [
            'name' => 'max:255',
            'email' => 'email|max:255',
            'fnacimiento'=>'date_format:Y-m-d',
            'password' => 'nullable|min:6',
        ];
    }
}
