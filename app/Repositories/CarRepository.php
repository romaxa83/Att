<?php

namespace App\Repositories;

use App\Car;
use App\Helpers\ParseQueryParams;

class CarRepository
{

    public function query()
    {
        return resolve(Car::class)->query();
    }

    public function getAllWithPaginate($request)
    {
        $perPage = $request['perPage'] ?? Car::PER_PAGE;

        $query = $this->query();

        if(isset($request['sort']) && !empty($request['sort'])){
            $params = ParseQueryParams::bySort($request['sort']);
            $query->orderBy($params['field'], $params['type']);
        }

        return $query->paginate($perPage);
    }

    public function search($query)
    {
        $perPage = $request['perPage'] ?? Car::PER_PAGE;

        return $this
            ->query()
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('number', 'like', '%'.$query.'%')
            ->orWhere('vin_code', 'like', '%'.$query.'%')
            ->paginate($perPage)
            ;
    }
}
