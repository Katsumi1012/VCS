<?php

namespace App\Http\Controllers;

use App\User;
use App\Teacher;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function ShowTeacher(Teacher $teacher){
        return view('backend.info.teacher', compact('teacher'));
    }
    public function ShowStudent(Student $student){
        return view('backend.info.student', compact('student'));
    }
    public function ViewTeacher(){
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('backend.info.ViewTeacher', compact('teachers'));
    }
    public function ViewStudent(){
        $students = Student::with('user')->latest()->paginate(10);
        return view('backend.info.ViewStudent', compact('students'));
    }
}
