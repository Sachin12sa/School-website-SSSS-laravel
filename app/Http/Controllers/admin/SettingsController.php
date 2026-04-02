<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    public function index() {
        $settings = SiteSetting::all_settings();
        return view('admin.settings.index', compact('settings'));
    }
    public function update(Request $request) {
        $data = $request->except(['_token', '_method']);
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            $data['logo'] = $path;
        }
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            $data['favicon'] = $path;
        }
        SiteSetting::setMany($data);
        return back()->with('success', 'Settings saved successfully.');
    }
}