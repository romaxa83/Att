<?php

namespace App\Resources;

use App\Car;
use App\Helpers\DateFormat;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Car $car */
        $car = $this;

        return [
            'id' => $car->id,
            'name' => $car->name,
            'number' => $car->number,
            'color' => $car->color,
            'year' => $car->year,
            'model' => $car->model->name,
            'manufacture' => $car->manufacture->name,
            'created' => DateFormat::front($car->created_at),
            'updated' => DateFormat::front($car->updated_at),
        ];
    }
}
