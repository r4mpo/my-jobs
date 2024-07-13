<?php

namespace App\Services;

use App\Interfaces\ApiDataInterface;
use App\Models\Vacancies\AddressVacancy;

class AddressService implements ApiDataInterface
{
    public function get($url): array
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPGET, true);

        $response = curl_exec($curl);
        curl_close($curl);

        return (array) json_decode($response);
    }

    public function register($data): object
    {
        $zip_code = preg_replace('/\D/', '', $data['cep']);

        if ($address = AddressVacancy::where('zip_code', $zip_code)->first()) {
            return $address;
        }

        $new_address = new AddressVacancy;

        $new_address->zip_code = $zip_code;
        $new_address->street = $data['logradouro'];
        $new_address->complement = $data['complemento'];
        $new_address->neighborhood = $data['bairro'];
        $new_address->locality = $data['localidade'];
        $new_address->uf = $data['uf'];
        $new_address->ibge = $data['ibge'];
        $new_address->gia = $data['gia'];
        $new_address->ddd = $data['ddd'];
        $new_address->siafi = $data['siafi'];

        $new_address->save();

        return $new_address;
    }
}
