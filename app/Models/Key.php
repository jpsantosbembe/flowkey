<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users() {
        return $this->belongsToMany(User::class, 'key_authorizations', 'key_id', 'user_id')->withPivot('is_active')->wherePivot('is_active', true);;
    }

    public function coordinators() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coordinators_keys', 'key_id', 'user_id');
    }
}
