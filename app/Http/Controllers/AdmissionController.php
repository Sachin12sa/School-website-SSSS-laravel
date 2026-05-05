<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\PageHero;
use App\Models\PageSection;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $hero = PageHero::forPage('admissions');
        $sections = PageSection::forPageCached('admissions');
        $formConfig = $this->formConfig();

        return view('admissions', [
            'hero' => $hero,
            'sections' => $sections,
            'sectionsBeforeForm' => $sections->where('layout', '!=', 'cta'),
            'ctaSections' => $sections->where('layout', 'cta'),
            'formConfig' => $formConfig,
            'classOptions' => $formConfig['classes'],
            'visibleFields' => $formConfig['visible_fields'],
            'requiredFields' => $formConfig['required_fields'],
        ]);
    }

    public function store(Request $request)
    {
        $config = $this->formConfig();
        $rules = [
            'applicant_first_name' => in_array('applicant_first_name', $config['required_fields'], true) ? 'required|string|max:100' : 'nullable|string|max:100',
            'applicant_last_name' => in_array('applicant_last_name', $config['required_fields'], true) ? 'required|string|max:100' : 'nullable|string|max:100',
            'parent_name' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'phone' => 'required|string|max:30',
            'class_applying' => 'required|string|max:100',
            'message' => 'nullable|string|max:2000',
        ];

        foreach (['dob', 'gender', 'nationality', 'religion', 'address', 'relationship', 'occupation', 'income', 'previous_school', 'last_class'] as $field) {
            $rules[$field] = in_array($field, $config['required_fields'], true) ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

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
            'extra_data'     => collect($validated)->except([
                'applicant_first_name', 'applicant_last_name', 'parent_name', 'email', 'phone', 'class_applying', 'message',
            ])->filter(fn ($value) => filled($value))->all(),
            'status'         => 'new',
            'submitted_at'   => now(),
        ]);

        return back()->with('success',
            trim("Thank you, {$firstName}! " . $config['success_message'] . " We will contact you at {$request->input('email')} within 2-3 working days.")
        );
    }

    private function formConfig(): array
    {
        $defaultFields = [
            'applicant_first_name', 'applicant_last_name', 'dob', 'gender', 'nationality', 'religion', 'address',
            'parent_name', 'relationship', 'email', 'phone', 'occupation', 'income',
            'class_applying', 'previous_school', 'last_class', 'message',
        ];

        $classes = collect(explode('|', SiteSetting::get('admission_class_options', 'Grade 1|Grade 2|Grade 3|Grade 4|Grade 5|Grade 6|Grade 7|Grade 8|Grade 9|Grade 10|+2 Science|+2 Management')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $visible = collect(explode(',', SiteSetting::get('admission_visible_fields', implode(',', $defaultFields))))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $required = collect(explode(',', SiteSetting::get('admission_required_fields', 'applicant_first_name,parent_name,email,phone,class_applying')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->intersect(array_merge($visible, ['parent_name', 'email', 'phone', 'class_applying']))
            ->values()
            ->all();

        return [
            'year' => SiteSetting::get('admission_year', '2026-27'),
            'intro' => SiteSetting::get('admission_form_intro', 'Complete this form to apply for admission. Our admissions team will contact you within 2-3 working days.'),
            'success_message' => SiteSetting::get('admission_success_message', 'Your application has been submitted successfully.'),
            'classes' => $classes,
            'visible_fields' => $visible,
            'required_fields' => $required,
        ];
    }
}
