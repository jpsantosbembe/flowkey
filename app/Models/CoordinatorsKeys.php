<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoordinatorsKeys extends Model
{
    public $table = 'coordinators_keys';

    protected $fillable = [
        'docente_id',
        'key_id',
    ];

}
