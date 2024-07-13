<?php

namespace App\Models\Vacancies;

use App\Models\ModelDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddressVacancy extends ModelDefault
{
    use HasFactory;

    protected $fillable = [
        "zip_code",
        "street",
        "complement",
        "neighborhood",
        "locality",
        "uf",
        "ibge",
        "gia",
        "ddd",
        "siafi"
    ];
}
