<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomMessage extends Model
{
    use HasFactory;

    public $guarded = [];
    public $with = ['user'];

    public function classroom() : BelongsTo
    {
        return $this->belongsTo(ClassroomMessage::class);
    } 

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
