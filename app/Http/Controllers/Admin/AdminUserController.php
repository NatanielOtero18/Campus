<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    //
    public function index(Request $request)
    {
        return Inertia::render('Admin/index', [
            'students' => User::query()
                ->with('role')  
                ->where('role_type', 'like', '%' . 'Student')
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRelation('role','name', 'like', '%' . $search . '%');
                })
                ->paginate(10)
                ->through(fn($user) => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->role->name,
                    'role' => 'Student',
                    'email' => $user->email,
                    'level' => $user->role->level,
                    'membership' => $user->role->membership,
                    'classroom_id' => $user->role->classroom_id


                ]),
            'teachers' => User::query()
                ->with('role')
                ->where('role_type', 'like', '%' . 'Teacher')
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRelation('role','name', 'like', '%' . $search . '%');

                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->role->name,
                    'email' => $user->email,
                    'role' => 'Teacher',
                    'classroom_id' => $user->role->classroom_id,
                    'contact_email' => $user->role->contact_email,
                    'classroom_name' => $user?->role?->classroom?->name

                ]),
            'query' => $request->only(['search']),
            'classrooms' => Classroom::has('teacher')->withCount('students')->get()->filter(function ($clrm) {
                return $clrm->students_count < $clrm->quota;
            }),
            'avClassrooms' => Classroom::doesntHave('teacher')->get()

        ]);
    }

    
    public function storeStudent(Request $request)
    {
        $usAtt = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed'],

        ]);

        $user = User::create($usAtt);

        $stuAtt = $request->validate([
            'name ' => 'required|string|max:255',
            'classroom_id' => 'nullable|numeric',
            'membership' => 'boolean',
            'level' => 'required|string|max:255'
        ]);

        $student = Student::create($stuAtt);
        $student->user()->save($user);
        event(new Registered($user));

        return redirect(route('AdminPanel'));

    }

    public function storeTeacher(Request $request)
    {
        $usAtt = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed'],

        ]);

        $user = User::create($usAtt);

        $teAtt = $request->validate([
            'name ' => 'required|string|max:255',
            'classroom_id' => 'numeric|nullable',
            'contact_email' => 'required|email|max:255|unique:' . Teacher::class,

        ]);

        $teacher = Teacher::create($teAtt);
        $teacher->user()->save($user);

        event(new Registered($user));

        return redirect(route('AdminPanel'));

    }

    public function updateStudent(Request $request, User $user)
    {
        $att = $request->validate([

            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],


        ]);

        $stuAtt = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|numeric',
            'membership' => 'boolean',
            'level' => 'required|string|max:255'
        ]);

        $user->update($att);
        $user->role->update($stuAtt);


    }

    public function updateTeacher(Request $request, User $user)
    {
        $att = $request->validate([

            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],


        ]);

        $teAtt = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|numeric',
            'contact_email' => ['required', 'email', Rule::unique('teachers', 'contact_email')->ignore($user->role->id)],
        ]);

        $user->update($att);
        $user->role->update($teAtt);


    }
}
