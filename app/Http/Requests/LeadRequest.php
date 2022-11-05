<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'wallet' => 'required',
            'type' => 'required|string',
            'email' => 'required|email',
            'method' => 'required|string',
            'exchange_rate' => 'required|numeric',
            'send.*.cost' => 'required|numeric',
            'send.*.currency' => 'required|string',
            'need.*.cost' => 'required|numeric',
            'need.*.currency' => 'required|string',
        ];
    }
}
