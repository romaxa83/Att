<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $vin_code
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 */

class Car extends Model
{
    const PER_PAGE = 10;

    protected $table = 'cars';

    protected $fillable = [
        'name', 'number', 'color', 'vin_code'
    ];
}
