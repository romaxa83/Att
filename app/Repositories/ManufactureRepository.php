<?php

namespace App\Repositories;

use App\Manufacture;
use Illuminate\Database\Eloquent\Collection;

class ManufactureRepository
{

    public function query()
    {
        return resolve(Manufacture::class)->query();
    }

    public function search($query)
    {
        if(!$query){
            return new Collection();
        }

        return $this->query()
            ->where('name', 'like', $query.'%')
            ->get()
            ;
    }
}
