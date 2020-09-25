<?php

namespace App\Repositories;

use App\Car;

class CarRepository
{
    public function query()
    {
        return resolve(Car::class)->query();
    }

    public function getAllWithPaginate($request)
    {
        $perPage = $request['perPage'] ?? Car::PER_PAGE;

        return $this->query()->paginate($perPage);
    }
}
