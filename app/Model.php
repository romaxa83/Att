<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ElModel;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property string $name
 * @property string $make_id
 * @property string $model_id
 */

class Model extends ElModel
{
    use InsertOnDuplicateKey;

    public $timestamps = false;

    protected $table = 'models';

    protected $fillable = [
        'name'
    ];
}
