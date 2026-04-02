<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $filter = request('status');
        $admissions = Admission::when($filter, fn($q) => $q->where('status', $filter))
            ->orderByDesc('submitted_at')
            ->paginate(20);
        return view('admin.admissions.index', compact('admissions', 'filter'));
    }

    public function show(Admission $admission)
    {
        return view('admin.admissions.show', compact('admission'));
    }

    public function updateStatus(Request $request, Admission $admission)
    {
        $request->validate([
            'status'      => 'required|in:new,reviewed,accepted,rejected',
            'admin_notes' => 'nullable|string',
        ]);
        $admission->update($request->only('status', 'admin_notes'));
        return back()->with('success', 'Status updated.');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();
        return back()->with('success', 'Application deleted.');
    }
}