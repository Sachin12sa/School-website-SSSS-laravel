<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller {
    public function index() { return view('contact'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:3000',
        ]);
        Contact::create($data);
        return back()->with('success', 'Thank you for your message! We will get back to you within 24 hours.');
    }
}