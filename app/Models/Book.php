<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function borrowing() {
        return $this->hasMany(Borrowing::class);
    }

    // public function transaction() {
    //     return $this->hasMany(Transaction::class);
    // }

    public function item() {
        return $this->hasMany(Items::class);
    }

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_at',
        'category_id',
        'ISBN',
        'description',
        'status'
    ];
}
