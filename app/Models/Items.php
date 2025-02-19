<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'inv_id',
        'book_id',
        'status'
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function transaction() {
        return $this->hasMany(Transaction::class);
    }
}
