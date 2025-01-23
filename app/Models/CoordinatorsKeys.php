<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoordinatorsKeys extends Model
{
    public $table = 'coordinators_keys';

    protected $fillable = [
        'user_id',
        'key_id',
    ];

    public function key() {
        return $this->belongsTo(Key::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
