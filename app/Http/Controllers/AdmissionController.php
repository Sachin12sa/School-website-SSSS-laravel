<?php namespace App\Http\Controllers;
use App\Models\{Admission, Contact};
use Illuminate\Http\Request;

class AdmissionController extends Controller {
    public function index() { return view('admissions'); }
    public function store(Request $request) {
        $data = $request->validate([
            'applicant_name' => 'required|string|max:200',
            'dob' => 'nullable|date',
            'parent_name' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'phone' => 'required|string|max:20',
            'class_applying' => 'required|string|max:100',
            'message' => 'nullable|string|max:2000',
        ]);
        Admission::create($data);
        return back()->with('success', 'Thank you! Your admission application has been submitted successfully. We will contact you shortly.');
    }
}

