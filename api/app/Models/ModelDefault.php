<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDefault extends Model
{
    use HasFactory;

    /**
     * We instantiate the controller to use data formatting. Therefore, all models can use these formats.
     *
     * @return string
     */
    public function __formatDatas($type, $data): string
    {
        $controller = new Controller;
        $formattingData = $controller->format($type, $data);

        if ($formattingData) {
            return $formattingData;
        }

        return '';
    }
}