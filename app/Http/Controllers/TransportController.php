<?php
// ── TransportController.php ──────────────────────────────────────────────────
// Save to: app/Http/Controllers/TransportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Storage};

class TransportController extends Controller
{
    public function index()
    {
        return view('transport');
    }

    public function report(Request $request)
    {
        $data = $request->validate([
            'issue_type'    => 'required|string|max:100',
            'bus_number'    => 'nullable|string|max:30',
            'location'      => 'required|string|max:255',
            'reporter_name' => 'nullable|string|max:200',
            'description'   => 'required|string|max:3000',
            'attachment'    => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

        // Store attachment if provided
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')
                ->store('transport-reports', 'public');
        }

        $data['reported_at'] = now();
        $data['status']      = 'new';

        // You can save to a DB table or email the transport coordinator.
        // Quick email option (enable if mail is configured):
        // Mail::to(config('mail.transport_email', \App\Models\SiteSetting::get('email')))->send(...)

        // Log it for now (add a TransportReport model/migration if needed)
        \Illuminate\Support\Facades\Log::info('Transport report submitted', $data);

        return back()->with('report_success', true);
    }
}


