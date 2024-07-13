<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Function to format Telephone, Zip_Code, CPF, CNPJ and RG
     *
     * Choose formatting type (phone, zip code, cpf, cnpj or rg)
     * Remember to put it in lowercase
     * @param $type string
     *
     * Send string to be formatted ex: 13974208014;
     * @param $string string
     *
     * Number of characters to be formatted,
     * only fits phone 10 for old standard and 11 for new standard with 9
     * @param $size integer
     *
     *
     * Formatted value of the chosen pattern
     * @return $string string
     */

    public function format($type = "", $string, $size = 10): string
    {
        $string = preg_replace("/[^0-9]/", "", $string); // Corrigido para adicionar delimitadores válidos para expressão regular

        switch ($type) {
            case 'phone':
                if ($size === 10) {
                    $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
                } elseif ($size === 11) {
                    $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) . '-' . substr($string, 7);
                }
                break;

            case 'zip_code':
                $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
                break;

            case 'money':
                $string = 'R$ ' . number_format(($string / 100), 2, ',', '');
                break;

            case 'cpf':
                $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
                break;

            case 'cnpj':
                $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
                break;

            case 'rg':
                $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3);
                break;

            default:
                $string = 'It is necessary to define a type (phone, zip_code, cpf, cnpj, rg)';
                break;
        }

        return $string;
    }
}