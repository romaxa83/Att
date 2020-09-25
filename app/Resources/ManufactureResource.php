<?php

namespace App\Resources;

use App\Car;
use App\Helpers\DateFormat;
use App\Manufacture;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufactureResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Manufacture $model */
        $model = $this;

        return [
            'id' => $model->id,
            'make_id' => $model->make_id,
            'name' => $model->name,
            'models' => ModelResource::collection($model->models)
        ];
    }
}
