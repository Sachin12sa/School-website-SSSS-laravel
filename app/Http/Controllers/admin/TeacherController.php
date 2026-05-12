<?php namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller {
    public function index() {
        $teachers = Teacher::orderBy('order')->paginate(20);
        $stats = [
            'total' => Teacher::count(),
            'published' => Teacher::where('is_published', true)->count(),
            'hidden' => Teacher::where('is_published', false)->count(),
            'departments' => Teacher::whereNotNull('department')->where('department', '!=', '')->distinct('department')->count('department'),
        ];

        return view('admin.teachers.index', compact('teachers', 'stats'));
    }
    public function create() { return view('admin.teachers.form', ['teacher' => new Teacher]); }
    public function store(Request $request) {
        $data = $this->validated($request);
        if ($request->hasFile('photo')) $data['photo'] = $request->file('photo')->store('teachers', 'public');
        Teacher::create($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added.');
    }
    public function edit(Teacher $teacher) { return view('admin.teachers.form', compact('teacher')); }
    public function update(Request $request, Teacher $teacher) {
        $data = $this->validated($request);
        if ($request->hasFile('photo')) $data['photo'] = $request->file('photo')->store('teachers', 'public');
        $teacher->update($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated.');
    }
    public function destroy(Teacher $teacher) { $teacher->delete(); return back()->with('success', 'Teacher deleted.'); }
    private function validated(Request $request): array {
        return $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);
    }
}
