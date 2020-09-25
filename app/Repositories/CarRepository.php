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

    public function getAll($request, $withPaginate = true)
    {
        $perPage = $request['perPage'] ?? Car::PER_PAGE;

        $query = $this->query()->with(['model', 'manufacture']);

        if(isset($request['manufacture']) && !empty($request['manufacture'])){
            $query->whereHas('manufacture', function($query) use ($request){
                $query->where('name', 'like', '%'.$request['manufacture'].'%');
            });
        }

        if(isset($request['model']) && !empty($request['model'])){
            $query->whereHas('model', function($query) use ($request){
                $query->where('name', 'like', '%'.$request['model'].'%');
            });
        }

        if(isset($request['year']) && !empty($request['year'])){
            $query->where('year', $request['year']);
        }

        if(isset($request['sort']) && !empty($request['sort'])){
            $params = ParseQueryParams::bySort($request['sort']);
            $query->orderBy($params['field'], $params['type']);
        }

        if($withPaginate){
            return $query->paginate($perPage);
        }

        return $query->get();
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
