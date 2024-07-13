<?php

namespace App\Models\Users;

use App\Models\ModelDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends ModelDefault
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'info',
        'user_id'
    ];

    const INFO_ADDRESS_CODE = 1;
    const INFO_IMAGE_CODE = 2;
    const INFO_EMAIL_CODE = 3;
    const INFO_PHONE_CODE = 4;

    public function getTypeInfo()
    {
        switch ($this->code) {
            case SELF::INFO_ADDRESS_CODE:
                $type = 'zip_code';
                break;

            case SELF::INFO_IMAGE_CODE:
                $type = 'image';
                break;

            case SELF::INFO_EMAIL_CODE:
                $type = 'email';
                break;
            case SELF::INFO_PHONE_CODE:
                $type = 'phone';
                break;

            default:
                $type = '';
                break;
        }

        return $type;
    }
}
