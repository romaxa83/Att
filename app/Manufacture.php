<?php

namespace App;

use Yadakhov\InsertOnDuplicateKey;
use App\Model as ModelCar;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property string $name
 * @property string $make_id
 * @property string $created_at
 * @property string $updated_at
 */

class Manufacture extends Model
{
    use InsertOnDuplicateKey;

    public $timestamps = false;

    protected $table = 'manufactures';

    protected $fillable = [
        'name', 'make_id'
    ];

    public function models()
    {
        return $this->hasMany(ModelCar::class, 'make_id', 'make_id');
    }
}
