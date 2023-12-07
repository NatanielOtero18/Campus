<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminClassController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/AdminClasses', [
            'classrooms' => Classroom::withCount('students')->with('teacher.user')->get()->map(fn($cls) =>
                [
                    'id' => $cls->id,
                    'name' => $cls->name,
                    'quota' => $cls->quota,
                    'students_count' => $cls->students_count,
                    'teacher_id' => $cls->teacher?->user->id,
                    'teacher_name' => $cls->teacher?->name,
                    'contact_email' => $cls->teacher?->contact_email
                ])

        ]);
    }

    public function getClassroom(Request $request, Classroom $classroom)
    {
        $teacher = $classroom->teacher?->user;

        return Inertia::render('Admin/ClassroomTable', [
            'classroom' => $classroom,
            'classrooms' => Classroom::all(),
            'students' => $classroom?->students()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');

                })
                ->paginate(10)
                ->through(fn($std) => [
                    'id' => $std?->user->id,
                    'name' => $std?->name,
                    'email' => $std?->user->email,
                    'classroom_id' => $std?->classroom_id,
                    'level' => $std?->level,
                    'membership' => $std?->membership
                ]),
            'teacher' => [
                'id' => $teacher?->id,
                'name' => $teacher?->role->name,
                'email' => $teacher?->email,
                'classroom_id' => $teacher?->role->classroom_id,
                'contact_email' => $teacher?->role->contact_email
            ],
            'avTeachers' => Teacher::doesntHave('classroom')->with('user')->get(),
            'query' => $request->only(['search']),
        ]);

    }

    public function store(Request $request)
    {
        $att = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name',
            'quota' => 'required|numeric',
        ]);

        Classroom::create($att);

        return redirect(route('AdminClasrooms'));


    }

    public function updateClassroom(Request $request, Classroom $classroom)
    {
        $att = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name',
            'quota' => 'required|numeric',
        ]);

        $classroom->update($att);
    }

    public function unassignTeacher(Classroom $classroom)
    {
        $tea = $classroom->teacher;
        $tea->classroom_id = null;
        $tea->save();

    }

    public function assignTeacher(Request $request, Classroom $classroom)
    {
        $tea = $request['teacher'];
        $teacher = Teacher::find($tea['id']);
        $teacher->classroom_id = $classroom->id;
        $teacher->save();
    }


}