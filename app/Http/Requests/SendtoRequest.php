<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendtoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->path() == 'confirm'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'seminar_day' => 'required',
            'seminar_name' => 'required',
            'venue_zip' => 'required',
            'venue_addr1' => 'required',
            'venue_addr3' => 'required',
            'venue_name' => 'required',
            'venue_tel' => 'required|integer|digits_between:5,11',
            'shipping_arrive_day' => 'required',
            'shipping_return_day' => 'required',
        ];
        
    }
}
