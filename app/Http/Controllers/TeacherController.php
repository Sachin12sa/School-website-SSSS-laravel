<?php

namespace App\Http\Controllers;

use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::published()->orderBy('order')->get()->groupBy('department');
        return view('teachers', compact('teachers'));
    }
}