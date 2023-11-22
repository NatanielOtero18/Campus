<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TeacherController extends Controller
{
    //
    public function index(Request $request)
    {
        $teacher = Teacher::find(auth()->user()->role_id);
        return Inertia::render("Teacher/TeacherClassroom", [
            'classroom' => $teacher->classroom,
            'activities' => Activity::where('teacher_id', 'like', auth()->user()->role->id)->paginate(10),
            'teacher' => $teacher,
            'students' => User::query()
                ->with('role')
                ->where('role_type', 'like', '%' . 'Student')
                ->whereRelation('role', 'classroom_id', '=', $teacher->classroom->id)
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRelation('role','name', 'like', '%' . $search . '%');

                })
                ->paginate(10)
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->role->name,
                    'role' => 'Student',
                    'email' => $user->email,
                    'level' => $user->role->level,
                    'membership' => $user->role->membership,
                    'classroom_id' => $user->role->classroom_id


                ]),
            'query' => $request->only(['search']),
        ]);
    }
   
    public function tasks(){
        return Inertia::render('Teacher/TeacherTasks',[
            'pending' => Activity::with('pendingCorrection')->where('teacher_id','like',auth()->user()->role->id)->get()
        ]);
    }
    public function assingActivity(User $user, Request $request)
    {
        $act = $request['activity'];
        $activity = Activity::find($act['id']);
        $student = Student::find($user->role->id);
        $student->activities()->syncWithoutDetaching()($activity,['created_at' => Carbon::now(),'updated_at'=> Carbon::now()]);
    }
    public function assingAll(Classroom $classroom , Request $request){
        $act = $request['activity'];       
        $activity = Activity::find($act['id']);
        foreach ($classroom->students as $stu) {          
           $stu->activities()->syncWithoutDetaching()($activity,['created_at'=> Carbon::now(),'updated_at'=> Carbon::now()]);
        }

    }
}
