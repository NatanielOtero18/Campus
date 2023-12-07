<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tickets extends Model
{
    use HasFactory;
    public $guarded = [];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
