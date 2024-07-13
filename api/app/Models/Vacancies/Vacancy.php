<?php

namespace App\Models\Vacancies;

use App\Http\Controllers\Controller;
use App\Models\ModelDefault;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends ModelDefault
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "short_description",
        "long_description",
        "wage",
        "zip_code",
        "user_id",
    ];

    protected $table = "vacancies";

    public function user(): object
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns all users who applied to a vacancy
     *
     * @return object
     */
    public function users(): object
    {
        return $this->belongsToMany(User::class);
    }

    public function zip(): object
    {
        $zip = AddressVacancy::where('zip_code', $this->zip_code)->orderBy('created_at', 'DESC')->first();

        $data = [
            'zip_code' => $this->__formatDatas('zip_code', $zip->zip_code),
            'street' => $zip->street,
            'complement' => $zip->complement,
            'neighborhood' => $zip->neighborhood,
            'locality' => $zip->locality,
            'uf' => $zip->uf,
            'ibge' => $zip->ibge,
            'gia' => $zip->gia,
            'ddd' => $zip->ddd,
            'siafi' => $zip->siafi
        ];

        return (object) $data;
    }
}
