<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = [
        'index_no',
        'name',
    ];

    protected $primaryKey = 'index_no';
    public $incrementing = false;
    protected $keyType = 'int';

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class);
    }

    public function marks()
{
    return $this->hasMany(Marks::class, 'index_no', 'index_no');
}
}
