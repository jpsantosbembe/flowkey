<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarita extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'nome',
    ];

    public function campuses() {
        return $this->belongsTo(Campus::class);
    }
}
