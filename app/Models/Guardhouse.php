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
    ];

    public function campuses() {
        return $this->belongsTo(Campus::class);
    }
}
