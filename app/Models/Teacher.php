<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Teacher extends Model
{
    use HasFactory;

    public $guarded = [];

    public function classroom() : BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user() : MorphOne
    {
        return $this->morphOne(User::class,'role');
    }

    public function activity() : HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
