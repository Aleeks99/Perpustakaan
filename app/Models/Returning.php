<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returning extends Model
{
    use HasFactory;

    // public function borrowing() {
    //     return $this->belongsTo(Borrowing::class);
    // }

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'transaction_id',
        'user_id',
        'returned_date',
        'detail',
        'fine_fee'
    ];
}
