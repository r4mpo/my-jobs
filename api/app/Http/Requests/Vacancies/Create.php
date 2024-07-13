<?php

namespace App\Http\Requests\Vacancies;

use App\Models\User;
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
            "short_description" => ["required", "max:60", "min:5"],
            "long_description" => ["required", "max:250", "min:10"],
            "wage" => ["required", "int"],
            "zip_code" => ["required"],
        ];
    }

    public function messages(): array
    {
        return [
            "max" => "The field :attribute must reach, at most, :max characters",
            "min" => "The field :attribute must reach, at most, :min characters",
            "required" => "The field :attribute is required, try again",
            "exists" => "The field :attribute is not valid, does not exist in the related table, try again",
            "integer" => "The field :attribute must be an integer value (in this case, enter the remuneration in cents)",
        ];
    }

    public function prepareForValidation(): void
    {
        $input = $this->all();

        if ($this->has('zip_code'))
            $input['zip_code'] = preg_replace("/[^0-9]/", "", $this->get('zip_code'));


        $input['user_id'] = auth()->id();

        $this->replace($input);
    }
}
