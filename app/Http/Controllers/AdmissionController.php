<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        return view('admissions');
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_name'    => 'required|string|max:200',
            'email'          => 'required|email|max:200',
            'phone'          => 'required|string|max:30',
            'class_applying' => 'required|string|max:100',
            'message'        => 'nullable|string|max:2000',
        ]);

        // Build the applicant_name from the two separate first/last name fields
        $firstName = trim($request->input('applicant_first_name', ''));
        $lastName  = trim($request->input('applicant_last_name', ''));
        $fullName  = trim($firstName . ' ' . $lastName) ?: 'Unnamed Applicant';

        Admission::create([
            'applicant_name' => $fullName,
            'dob'            => $request->input('dob'),
            'parent_name'    => $request->input('parent_name'),
            'email'          => $request->input('email'),
            'phone'          => $request->input('phone'),
            'class_applying' => $request->input('class_applying'),
            'message'        => $request->input('message'),
            'status'         => 'new',
            'submitted_at'   => now(),
        ]);

        return back()->with('success',
            "Thank you, {$firstName}! Your application has been submitted successfully. " .
            "We will contact you at {$request->input('email')} within 2–3 working days."
        );
    }
}