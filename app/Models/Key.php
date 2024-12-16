<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'label',
        'description',
        'guardhouse_id',
    ];

    public function guardhouse() {
        return $this->belongsTo(Guardhouse::class);
    }
}
