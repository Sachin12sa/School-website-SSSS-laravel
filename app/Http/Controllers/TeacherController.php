<?php

namespace App\Http\Controllers;

use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        // Load published teachers ordered by display order,
        // then group by department for the section headings.
        // Teachers with no department go under a '' key (shown without a heading).
        $teachers = Teacher::published()
            ->orderByRaw("CASE WHEN department IS NULL OR department = '' THEN 1 ELSE 0 END")
            ->orderBy('order')
            ->get()
            ->groupBy('department');

        return view('teachers', compact('teachers'));
    }
}