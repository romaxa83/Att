<?php

namespace App\Helpers;

use App\Car;
use Carbon\Carbon;

class ParseQueryParams
{
    public static function bySort($querySort)
    {
        $data['field'] = $querySort;
        $data['type'] = 'desc';

        if (substr($querySort, 0, 1) == '-') {
            $data['field'] = substr($querySort, 1);
            $data['type'] = 'asc';
        }

        if(!in_array($data['field'], Car::fields())){
            throw new \Exception("Нет возможности сортировать по полю - {$data['field']}");
        }

        return $data;

    }
}
