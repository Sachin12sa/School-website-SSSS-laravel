<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{NewsPost, Event, Admission, Contact, Teacher, Gallery};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'news' => NewsPost::count(),
            'events' => Event::count(),
            'teachers' => Teacher::count(),
            'galleries' => Gallery::count(),
            'new_admissions' => Admission::where('status','new')->count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
        ];
        $recentAdmissions = Admission::latest()->limit(5)->get();
        $recentContacts = Contact::latest()->limit(5)->get();
        return view('admin.dashboard', compact('stats', 'recentAdmissions', 'recentContacts'));
    }
}