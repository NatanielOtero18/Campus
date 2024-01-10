<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',       
        'quota',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
    public function classMessages(): HasMany
    {
        return $this->hasMany(ClassroomMessage::class);
    }
}
