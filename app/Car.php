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
 * @property string $year
 * @property int $manufacture_id
 * @property int $model_id
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

    public static function fields()
    {
        return ['id', 'name', 'number', 'color', 'vin_code', 'created_at', 'updated_at'];
    }

    public function model()
    {
        return $this->hasOne(\App\Model::class, 'model_id', 'model_id');
    }

    public function manufacture()
    {
        return $this->hasOne(\App\Manufacture::class, 'make_id', 'manufacture_id');
    }
}
