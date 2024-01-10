<?php

namespace App\Models;


use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tickets extends Model
{
    use HasFactory;
    public $guarded = [];

    public $with = ['user'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function thread():BelongsTo
    {
        return $this->BelongsTo(Thread::class);
    }
}
