<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;


    protected $guarded = [];
   
    
    
    public function teacher() : BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students() : BelongsToMany
    {
        return $this->belongsToMany(Student::class)
        ->as('task')
        ->withPivot('completed','score','submit','devolution','corrected');
        
    }

    public function pendingCorrection()
    {
        return $this->students()
        ->wherePivot('completed',true)
        ->wherePivot('corrected',false);
       
    }


}
