<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    protected $fillable = [
        'index_no',
        'subject_id',
        'marks'
    ];

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'index_no', 'index_no');
    }
}
