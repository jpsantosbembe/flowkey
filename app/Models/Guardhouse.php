<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardhouse extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',
        'campus_id',
    ];

    public function campus() {
        return $this->belongsTo(Campus::class);
    }

    public function keys() {
        return $this->hasMany(Key::class);
    }
}
