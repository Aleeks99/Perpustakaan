<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function borrowing() {
        return $this->hasOne(Borrowing::class);
    }

    public function returning() {
        return $this->hasOne(Returning::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function item() {
        return $this->belongsTo(Items::class);
    }

    protected $fillable = [
        'user_id',
        'item_id',
        'due_date',
        'detail',
        'extended_count'
        // 'note',
    ];
}
