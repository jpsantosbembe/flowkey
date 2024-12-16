<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyAuthorization extends Model
{
    //
    protected $fillable = [
        'key_id',
        'user_id',
        'is_active',
    ];

    public function key() {
        return $this->belongsTo(Key::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
