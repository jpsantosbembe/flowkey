<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowed_by_user_id',
        'given_by_user_id',
        'borrowed_key_id',
        'returned_by_user_id',
        'receiver_user_id',
        'borrowed_at',
        'returned_at'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime'
    ];

    public function borrowedBy() {
        return $this->belongsTo(User::class, 'borrowed_by_user_id');
    }

    public function givenBy() {
        return $this->belongsTo(User::class, 'given_by_user_id');
    }

    public function returnedBy() {
        return $this->belongsTo(User::class, 'returned_by_user_id')->withDefault();
    }

    public function key() {
        return $this->belongsTo(Key::class, 'borrowed_key_id');
    }

    public function receivedBy() {
        return $this->belongsTo(User::class, 'receiver_user_id')->withDefault();
    }

}
