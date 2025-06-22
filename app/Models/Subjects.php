<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->belongsToMany(Students::class);
    }
}
