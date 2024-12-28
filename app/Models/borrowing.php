<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function returning() {
    //     return $this->hasOne(Returning::class);
    // }

    protected $fillable = [
        // 'name',
        'transaction_id',
        'user_id',
        'borrowed_at'
    ];
}
