<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use \Dive\EloquentSuper\InheritsFromSuper;

    protected $guarded = [];

    protected function getSuperClass(): string
    {
        return User::class;
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
