<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivitiesController extends Controller
{
    //
    public function teacherIndex(Request $request)
    {

        return Inertia::render("Activities/TeacherActivities", [
            'activities' => Activity::where('teacher_id', 'like', auth()->user()->role->id)
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('title', 'like', '%' . $search . '%');
                    $query->orWhere('body', 'like', '%' . $search . '%');
                    $query->orWhere('id', 'like', $search);

                })
                ->paginate(10),
            'query' => $request->only(['search']),
        ]);
    }

    public function create(Request $request)
    {
        $valACt = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string',],
            'teacher_id' => ['required', 'numeric']
        ]);

        $activity = Activity::create($valACt);
    }
    public function update(Activity $activity, Request $request)
    {
        $valACt = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string',],
            'teacher_id' => ['required', 'numeric']
        ]);
        $activity->update($valACt);
    }

    public function showActivities(Request $request, User $user)
    {   
       
      
        return Inertia::render('Activities/ShowActivities', [
            'activities' => Student::find($user->role->id)
            ->activities()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');     
            })
            ->paginate(10)
            ,  
            'user' => $user,
            'query' => $request->only(['search']),  
            
                          
        ]);
    }

    public function correct(string $activityId, string $userId)
    {
        
       return Inertia::render('Teacher/ScoreActivity', [
            'activity' => Student::find($userId)->activities()->where('activities.id', $activityId)->first(),
            'user' => Student::find($userId)->user
       ]);

    }
    public function storeCorrection(Activity $activity, Request $request)
    {
        $student = Student::find($request->only(['studentID']))->first();
        $atts = $request->validate([
            'score' => ['required', 'numeric','min:1','max:10'],
            'devolution' => ['required','string'],
        ]);
        $student->activities()->updateExistingPivot($activity->id, [...$atts, 'corrected' => true]);
      
    }

}
