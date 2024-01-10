<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    //
    public function index()
    {

        return Inertia::render('Dashboard',[
            'pendingActivities' => Student::find(auth()->user()->role_id)->PendingActivities()->get()
        ]);
       
        
    }

    public function indexActivities()
    {
        return Inertia::render('Student/ActivitiesList',[
            'activities' => Student::find(auth()->user()->role_id)->activities()->get()
        ]);
    }

    public function showActivity(Activity $activity)
    {
        return Inertia::render('Student/ShowActiviy',[
            'activity' => Student::find(auth()->user()->role_id)->activities()->where('activities.id','like',$activity->id)->first()
        ]);
    }

    public function classroom()
    {   
        $classroom = Student::find(auth()->user()->role_id)->classroom;
        return Inertia::render('Student/Classroom',[
            'classroom' =>  $classroom,
            'teacher'=>  Teacher::with('user')->where('classroom_id','like',$classroom->id)->get()->map(fn($tea)=>[
                'id' => $tea->user->id,
                'name' => $tea->name
            ])->first(),
            'messages' => $classroom->classMessages()->orderBy('updated_at','desc')->get()
            
        ]); 
    }

    

    

    
}

