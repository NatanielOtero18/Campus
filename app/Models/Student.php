<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Student extends Model
{
    use HasFactory;

    public $guarded = [];
    public $with = ['classroom'];

    public function classroom() : BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class,'role');
    }

    public function activities() : BelongsToMany
    {
        return $this->belongsToMany(Activity::class)
        ->as('task')
        ->withPivot('completed','score','submit','devolution');
        
    }
}
