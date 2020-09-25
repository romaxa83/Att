<?php

namespace App\Services;

use App\Car;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarUpdateRequest;

class CarService
{
    /**
     * @param CarCreateRequest $request
     * @return Car
     */
    public function create(CarCreateRequest $request, $decodeData): Car
    {
        $model = new Car();
        $model->name = $request->input('name');
        $model->number = $request->input('number');
        $model->vin_code = $request->input('vin_code');
        $model->color = $request->input('color');
        $model->manufacture_id = $decodeData['manufacture_id'];
        $model->model_id = $decodeData['model_id'];
        $model->year = $decodeData['year'];
        $model->save();

        return $model;
    }

    public function update(CarUpdateRequest $request, Car $model): Car
    {
        $model->name = $request->input('name');
        $model->number = $request->input('number');
        $model->vin_code = $request->input('vin_code');
        $model->color = $request->input('color');
        $model->save();

        return $model;
    }

    /**
     * @param Car $model
     * @throws \Exception
     */
    public function remove(Car $model): void
    {
        if(!$model->forceDelete()){
            throw new \Exception("Не смог удалить модель - {$model->id}");
        }
    }
}
