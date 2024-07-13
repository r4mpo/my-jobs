<?php

namespace App\Http\Requests\Users\Infos;

use App\Models\Users\Info;
use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'in:1,2,3,4'],
            'info' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required.',
            'code.in' => 'code-info value invalid'
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        $input['user_id'] = auth()->id();

        if ((int) $this->get('code') === Info::INFO_PHONE_CODE || (int) $this->get('code') === Info::INFO_ADDRESS_CODE) {
            $input['info'] = preg_replace("/[^0-9]/", "", $this->get('info'));
        }

        $this->replace($input);
    }
}
