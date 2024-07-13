<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class Create extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Username is required.',
            'name.max' => 'The username must contain a maximum of :max characters.',
            'email.required' => 'User email is required.',
            'email.email' => 'User email is not in a valid format.',
            'email.max' => 'The user email must contain a maximum of :max characters.',
            'email.unique' => 'The users email is not available for use.',
            'password' => 'The users password is a required field.',
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        if ($this->has('password'))
            $input['password'] = Hash::make($this->get('password'));

        $this->replace($input);
    }
}