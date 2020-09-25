<?php

namespace App\Resources;

use App\Car;
use App\Helpers\DateFormat;
use App\Manufacture;
use App\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Model $model */
        $model = $this;

        return [
            'id' => $model->id,
            'make_id' => $model->make_id,
            'model_id' => $model->model_id,
            'name' => $model->name
        ];
    }
}

