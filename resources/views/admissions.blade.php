@extends('layouts.app')
@section('title', 'Admissions — Sathya Sai Shiksha Sadan')
@section('meta_description', 'Apply for admission to ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '. Admissions open for 2026–27.')

@push('styles')
<style>
@keyframes page-enter { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-4 { animation: page-enter .85s .52s both cubic-bezier(0.23,1,0.32,1); }

/* ── Process step connector ───────────────────────────────────── */
.step-connector {
    flex: 1; height: 2px;
    background: linear-gradient(90deg, var(--gold), rgba(201,162,39,0.2));
}

/* ── Step icon ────────────────────────────────────────────────── */
.step-icon {
    width: 56px; height: 56px; border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    transition: transform .22s var(--ease-spring), box-shadow .22s ease;
}
.step-wrap:hover .step-icon { transform: translateY(-3px); }

/* ── Form inputs — consistent style ──────────────────────────── */
.form-label {
    display: block;
    font-size: 10px; font-weight: 700;
    color: #6B7A8D;
    letter-spacing: 0.12em; text-transform: uppercase;
    margin-bottom: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.form-input {
    width: 100%;
    border: 1.5px solid rgba(13,27,46,0.12);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--navy);
    background: #fff;
    outline: none;
    transition: border-color .18s var(--ease-out), box-shadow .18s ease;
}

.form-input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(201,162,39,0.12);
}

.form-input.error { border-color: #EF4444; }
.form-input.error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
.form-error { color: #EF4444; font-size: 11px; margin-top: 4px; font-family: 'Plus Jakarta Sans',sans-serif; }

/* ── Step tabs ────────────────────────────────────────────────── */
.step-tab {
    padding: 18px 12px; text-align: center;
    font-size: 11px; font-weight: 700;
    border-bottom: 2px solid transparent;
    color: #9CA3AF;
    cursor: pointer;
    transition: color .18s var(--ease-out), border-color .18s var(--ease-out);
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.step-tab.active { color: var(--navy); border-color: var(--navy); }

.step-num {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 6px;
    font-size: 11px; font-weight: 800;
    background: #F3F4F6; color: #9CA3AF;
    transition: background .18s ease, color .18s ease;
}
.step-tab.active .step-num { background: var(--navy); color: #fff; }
.step-tab.done .step-num { background: var(--gold); color: var(--navy); }
.step-tab.done { color: var(--text-muted); }

/* ── Form section header ──────────────────────────────────────── */
.form-section-header {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: 24px;
    background: rgba(13,27,46,0.04);
    border: 1px solid rgba(13,27,46,0.06);
}
.form-section-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: var(--navy);
}

/* ── Nav buttons ──────────────────────────────────────────────── */
.btn-nav-next {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    padding: 12px 24px; border-radius: 10px;
    cursor: pointer; border: none;
    background: var(--navy); color: #fff;
    transition: background .18s ease, transform .16s var(--ease-spring);
}
.btn-nav-next:hover { background: var(--gold); transform: translateY(-1px); }
.btn-nav-next:active { transform: scale(0.97); }

.btn-nav-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600;
    padding: 12px 20px; border-radius: 10px;
    cursor: pointer;
    border: 1.5px solid rgba(13,27,46,0.14);
    background: transparent; color: var(--text-muted);
    transition: border-color .18s ease, color .18s ease, transform .16s var(--ease-spring);
}
.btn-nav-back:hover { border-color: var(--navy); color: var(--navy); }

.btn-submit {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    padding: 12px 28px; border-radius: 10px;
    cursor: pointer; border: none;
    background: #059669; color: #fff;
    box-shadow: 0 4px 16px rgba(5,150,105,0.28);
    transition: background .18s ease, transform .16s var(--ease-spring), box-shadow .18s ease;
}
.btn-submit:hover { background: #047857; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(5,150,105,0.38); }
.btn-submit:active { transform: scale(0.97); }

/* ── Document card ────────────────────────────────────────────── */
.doc-card {
    border-radius: 20px;
    border: 2px solid;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease;
}
@media (hover:hover) and (pointer:fine) {
    .doc-card:hover { transform: translateY(-5px); box-shadow: 0 20px 44px rgba(13,27,46,0.09); }
}

/* ── Date row ─────────────────────────────────────────────────── */
.date-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid rgba(13,27,46,0.06);
    transition: background .15s ease;
}
.date-row:last-child { border-bottom: none; }

/* ── Fee row ──────────────────────────────────────────────────── */
.fee-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid rgba(13,27,46,0.06);
    transition: background .15s ease;
}
.fee-row:last-child { border-bottom: none; }
@media (hover:hover) and (pointer:fine) {
    .fee-row:hover { background: rgba(201,162,39,0.03); border-radius: 8px; padding-left: 8px; padding-right: 8px; }
}

/* ── Grand CTA ────────────────────────────────────────────────── */
.grand-cta { position: relative; overflow: hidden; z-index: 1; }
.cta-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:-1; pointer-events:none; }
</style>
@endpush

@section('content')

@php
    $admissionSections = $sections ?? collect();
    $visibleFields = $visibleFields ?? [];
    $requiredFields = $requiredFields ?? [];
    $showField = fn ($key) => in_array($key, $visibleFields, true);
    $requiredField = fn ($key) => in_array($key, $requiredFields, true);
@endphp

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@if ($hero)
    <x-page-hero :hero="$hero" />
@else
<section class="relative flex items-center overflow-hidden" style="min-height:68vh;background:#060e1c">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600"
             class="w-full h-full object-cover opacity-20" alt="">
    </div>
    <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(6,14,28,0.97) 0%,rgba(13,27,46,0.88) 55%,rgba(201,162,39,0.08) 100%)"></div>

    <div class="absolute top-12 right-16 w-64 h-64 border rounded-full pointer-events-none hidden xl:block" style="border-color:rgba(255,255,255,0.04)"></div>
    <div class="absolute top-28 right-28 w-40 h-40 border rounded-full pointer-events-none hidden xl:block" style="border-color:rgba(201,162,39,0.08)"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-10 w-full py-32 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="h-anim-1" style="display:inline-flex;align-items:center;gap:8px;background:rgba(201,162,39,0.12);border:1px solid rgba(201,162,39,0.28);box-shadow:inset 0 1px 0 rgba(255,255,255,0.08);color:var(--gold);font-size:10.5px;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;padding:8px 18px;border-radius:50px;margin-bottom:1.5rem">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--gold)"></span>
                Admissions 2026–27 Open
            </div>
            <h1 class="h-anim-2 font-display font-bold text-white mb-5" style="font-size:clamp(2.8rem,6vw,4.8rem);line-height:1.06;letter-spacing:-0.025em">Apply to SSSS</h1>
            <p class="h-anim-3 text-white/60 leading-relaxed max-w-xl mx-auto mb-10" style="font-size:clamp(0.95rem,2vw,1.1rem);font-family:'Plus Jakarta Sans',sans-serif">
                Join our community of learners and begin a journey of excellence, character, and human values.
            </p>
            <div class="h-anim-4 flex flex-wrap gap-4 justify-center">
                <a href="#form" class="btn-primary">
                    Apply Online Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#documents" class="btn-ghost-white">Required Documents</a>
            </div>
        </div>
    </div>
</section>
@endif

@if ($admissionSections->isNotEmpty())
    @foreach (($sectionsBeforeForm ?? collect()) as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ ADMISSION PROCESS ════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff" id="process">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">How to Apply</div>
        <h2 class="section-title">Admission Process</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>

    <div class="relative stagger">
        {{-- Desktop connector line --}}
        <div class="hidden md:block absolute top-7 h-0.5 pointer-events-none" style="left:14%;right:14%;background:linear-gradient(90deg,var(--gold),rgba(201,162,39,0.3),var(--gold))"></div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 relative">
            @foreach([
                ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', '01', 'Collect Form',            'Get the admission form from our office or download from website.',    'var(--gold)'],
                ['M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12',                                                                    '02', 'Submit Documents',       'Submit completed form with all required documents before deadline.',    'var(--navy)'],
                ['M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138',       '03', 'Entrance Test',          'Appear for entrance examination (applicable for Grades 1–12).',        '#1a237e'],
                ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                     '04', 'Admission Confirmation', 'Receive admission letter and complete enrolment formalities.',           '#059669'],
            ] as [$iconPath, $step, $title, $desc, $color])
            <div class="step-wrap text-center relative">
                <div class="step-icon shadow-lg border-4 border-white mx-auto" style="background:{{ $color }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                    </svg>
                </div>
                <p class="text-xs font-black tracking-widest mb-1.5" style="color:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif">STEP {{ $step }}</p>
                <h4 class="font-display font-bold text-navy text-sm mb-2">{{ $title }}</h4>
                <p class="text-gray-400 text-xs leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
</section>
@endif

{{-- ══ APPLICATION FORM ═════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)" id="form">
<div class="max-w-3xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-12 reveal">
        <div class="section-label justify-center">Apply Now</div>
        <h2 class="section-title">Online Application Form</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $formConfig['intro'] ?? 'Complete this form to apply for admission.' }}</p>
    </div>

    {{-- Success --}}
    @if(session('success'))
    <div class="flex items-start gap-3 rounded-2xl p-5 mb-8 border" style="background:rgba(5,150,105,0.06);border-color:rgba(5,150,105,0.2)">
        <svg class="w-5 h-5 shrink-0 mt-0.5" style="color:#059669" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <div>
            <p class="font-bold text-sm" style="color:#047857;font-family:'Plus Jakarta Sans',sans-serif">Application Submitted!</p>
            <p class="text-sm mt-0.5" style="color:#065f46;font-family:'Plus Jakarta Sans',sans-serif">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Multi-step form --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden reveal"
         x-data="{ step: 1, maxStep: 3 }">

        {{-- Step tabs --}}
        <div class="grid grid-cols-3 border-b border-gray-100">
            @foreach([[1,'Student Info'],[2,'Guardian Info'],[3,'Academic Details']] as [$n,$label])
            <div :class="{
                    'active': step === {{ $n }},
                    'done': step > {{ $n }}
                 }"
                 class="step-tab"
                 @click="step >= {{ $n }} ? step = {{ $n }} : null">
                <div class="step-num">
                    <span x-show="step <= {{ $n }}">{{ $n }}</span>
                    <svg x-show="step > {{ $n }}" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="hidden sm:inline">{{ $label }}</span>
            </div>
            @endforeach
        </div>

        {{-- Progress bar --}}
        <div class="h-0.5" style="background:rgba(13,27,46,0.06)">
            <div class="h-full transition-all duration-500" style="background:var(--gold)"
                 :style="`width: ${((step-1)/2)*100}%`"></div>
        </div>

        <form action="{{ route('admissions.store') }}" method="POST" class="p-8 lg:p-10">
            @csrf

            {{-- ── STEP 1: Student Info ── --}}
            <div x-show="step === 1">
                <div class="form-section-header">
                    <div class="form-section-icon">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-navy text-sm">Student Information</div>
                        <div class="text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">Personal details of the applicant</div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">First Name @if($requiredField('applicant_first_name'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="applicant_first_name" value="{{ old('applicant_first_name') }}" class="form-input {{ $errors->has('applicant_first_name') ? 'error' : '' }}" placeholder="Student's first name" @if($requiredField('applicant_first_name')) required @endif>
                            @error('applicant_first_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @if ($showField('applicant_last_name'))
                        <div>
                            <label class="form-label">Last Name @if($requiredField('applicant_last_name'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="applicant_last_name" value="{{ old('applicant_last_name') }}" class="form-input {{ $errors->has('applicant_last_name') ? 'error' : '' }}" placeholder="Student's last name" @if($requiredField('applicant_last_name')) required @endif>
                            @error('applicant_last_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @if ($showField('dob'))
                        <div>
                            <label class="form-label">Date of Birth @if($requiredField('dob'))<span class="text-red-400">*</span>@endif</label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-input {{ $errors->has('dob') ? 'error' : '' }}" @if($requiredField('dob')) required @endif>
                            @error('dob')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                        @if ($showField('gender'))
                        <div>
                            <label class="form-label">Gender @if($requiredField('gender'))<span class="text-red-400">*</span>@endif</label>
                            <select name="gender" class="form-input {{ $errors->has('gender') ? 'error' : '' }}" @if($requiredField('gender')) required @endif>
                                <option value="">Select…</option>
                                <option value="Male" {{ old('gender')==='Male'?'selected':'' }}>Male</option>
                                <option value="Female" {{ old('gender')==='Female'?'selected':'' }}>Female</option>
                                <option value="Other" {{ old('gender')==='Other'?'selected':'' }}>Other</option>
                            </select>
                            @error('gender')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @if ($showField('nationality'))
                        <div>
                            <label class="form-label">Nationality @if($requiredField('nationality'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="nationality" value="{{ old('nationality','Nepali') }}" class="form-input {{ $errors->has('nationality') ? 'error' : '' }}" @if($requiredField('nationality')) required @endif>
                            @error('nationality')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                        @if ($showField('religion'))
                        <div>
                            <label class="form-label">Religion @if($requiredField('religion'))<span class="text-red-400">*</span>@else<span class="text-gray-300 font-normal">(optional)</span>@endif</label>
                            <input type="text" name="religion" value="{{ old('religion') }}" class="form-input {{ $errors->has('religion') ? 'error' : '' }}" @if($requiredField('religion')) required @endif>
                            @error('religion')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                    </div>
                    @if ($showField('address'))
                    <div>
                        <label class="form-label">Permanent Address @if($requiredField('address'))<span class="text-red-400">*</span>@endif</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-input {{ $errors->has('address') ? 'error' : '' }}" placeholder="Full residential address" @if($requiredField('address')) required @endif>
                        @error('address')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    @endif
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="button" @click="step = 2" class="btn-nav-next">
                        Next: Guardian Info
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 2: Guardian Info ── --}}
            <div x-show="step === 2" x-cloak>
                <div class="form-section-header">
                    <div class="form-section-icon">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-navy text-sm">Guardian Information</div>
                        <div class="text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">Parent or legal guardian details</div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Parent / Guardian Name <span class="text-red-400">*</span></label>
                            <input type="text" name="parent_name" value="{{ old('parent_name') }}" required class="form-input {{ $errors->has('parent_name') ? 'error' : '' }}">
                            @error('parent_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Relationship @if($requiredField('relationship'))<span class="text-red-400">*</span>@endif</label>
                            <select name="relationship" class="form-input {{ $errors->has('relationship') ? 'error' : '' }}" @if($requiredField('relationship')) required @endif>
                                <option>Father</option>
                                <option>Mother</option>
                                <option>Guardian</option>
                            </select>
                            @error('relationship')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Email Address <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-input {{ $errors->has('email') ? 'error' : '' }}">
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Phone Number <span class="text-red-400">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="form-input {{ $errors->has('phone') ? 'error' : '' }}">
                            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @if ($showField('occupation'))
                        <div>
                            <label class="form-label">Occupation @if($requiredField('occupation'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="occupation" value="{{ old('occupation') }}" class="form-input {{ $errors->has('occupation') ? 'error' : '' }}" @if($requiredField('occupation')) required @endif>
                            @error('occupation')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                        @if ($showField('income'))
                        <div>
                            <label class="form-label">Annual Income (NRS) @if($requiredField('income'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="income" value="{{ old('income') }}" class="form-input {{ $errors->has('income') ? 'error' : '' }}" @if($requiredField('income')) required @endif>
                            @error('income')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" @click="step = 1" class="btn-nav-back">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Back
                    </button>
                    <button type="button" @click="step = 3" class="btn-nav-next">
                        Next: Academic Details
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 3: Academic Details + Submit ── --}}
            <div x-show="step === 3" x-cloak>
                <div class="form-section-header">
                    <div class="form-section-icon">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-navy text-sm">Academic Details</div>
                        <div class="text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">Previous education and class applying for</div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="form-label">Class Applying For <span class="text-red-400">*</span></label>
                        <select name="class_applying" required class="form-input {{ $errors->has('class_applying') ? 'error' : '' }}">
                            <option value="">Select a class…</option>
                            @foreach($classOptions as $cls)
                            <option value="{{ $cls }}" {{ old('class_applying')===$cls?'selected':'' }}>{{ $cls }}</option>
                            @endforeach
                        </select>
                        @error('class_applying')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @if ($showField('previous_school'))
                        <div>
                            <label class="form-label">Previous School @if($requiredField('previous_school'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="previous_school" value="{{ old('previous_school') }}" class="form-input {{ $errors->has('previous_school') ? 'error' : '' }}" @if($requiredField('previous_school')) required @endif>
                            @error('previous_school')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                        @if ($showField('last_class'))
                        <div>
                            <label class="form-label">Last Class / Grade @if($requiredField('last_class'))<span class="text-red-400">*</span>@endif</label>
                            <input type="text" name="last_class" value="{{ old('last_class') }}" class="form-input {{ $errors->has('last_class') ? 'error' : '' }}" @if($requiredField('last_class')) required @endif>
                            @error('last_class')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        @endif
                    </div>
                    @if ($showField('message'))
                    <div>
                        <label class="form-label">Additional Message <span class="text-gray-300 font-normal">(optional)</span></label>
                        <textarea name="message" rows="4" class="form-input" style="resize:none" placeholder="Any special requirements or questions…">{{ old('message') }}</textarea>
                    </div>
                    @endif
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" @click="step = 2" class="btn-nav-back">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Back
                    </button>
                    <button type="submit" class="btn-submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Submit Application
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
</section>

{{-- ══ REQUIRED DOCUMENTS ═══════════════════════════════════════════════ --}}
@if ($admissionSections->isEmpty())
<section class="py-28" style="background:#fff" id="documents">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">What to Bring</div>
        <h2 class="section-title">Required Documents</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>
    <div class="grid md:grid-cols-3 gap-6 stagger">
        @foreach([
            ['Primary Level (1–5)',    'var(--gold)',  [
                'Birth certificate (original + copy)',
                'Recent passport photos (4 copies)',
                'Previous school report card',
                'Transfer certificate (if applicable)',
                'Character certificate',
                'Medical fitness certificate',
            ]],
            ['Secondary Level (6–10)', 'var(--navy)',  [
                'Mark sheets of previous classes',
                'Transfer certificate from previous school',
                'Character certificate',
                'Birth certificate',
                'Recent passport photos (4 copies)',
                'Medical fitness certificate',
            ]],
            ['+2 Level (11–12)',        '#DC2626',     [
                'Grade 10 mark sheet & certificate',
                'Transfer certificate',
                'Character certificate',
                'Migration certificate (if different board)',
                'Recent passport photos (4 copies)',
                'Medical fitness certificate',
            ]],
        ] as [$level, $color, $docs])
        <div class="doc-card p-7" style="border-color:{{ $color }}">
            <h3 class="font-display font-bold text-lg mb-5" style="color:{{ $color }}">{{ $level }}</h3>
            <ul class="space-y-3">
                @foreach($docs as $doc)
                <li class="flex items-start gap-2.5 text-sm" style="color:#4B5563;font-family:'Plus Jakarta Sans',sans-serif">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $color }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $doc }}
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ IMPORTANT DATES + FEES ════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)" id="dates">
<div class="max-w-4xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Key Information</div>
        <h2 class="section-title">Dates &amp; Fees</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>

    <div class="grid sm:grid-cols-2 gap-8 reveal">
        {{-- Admission Timeline --}}
        <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(201,162,39,0.1);border:1px solid rgba(201,162,39,0.2)">
                    <svg class="w-4 h-4" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="font-display font-bold text-navy text-base">Admission Timeline</h4>
            </div>
            @foreach([['Form Distribution Starts','January 15, 2026'],['Last Date for Submission','March 15, 2026'],['Entrance Test Date','March 25, 2026'],['Results Announcement','April 1, 2026']] as [$k,$v])
            <div class="date-row">
                <span class="text-sm" style="color:#4B5563;font-family:'Plus Jakarta Sans',sans-serif">{{ $k }}</span>
                <span class="text-sm font-bold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $v }}</span>
            </div>
            @endforeach
        </div>

        {{-- Session Details --}}
        <div class="bg-white rounded-[20px] p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(13,27,46,0.07);border:1px solid rgba(13,27,46,0.1)">
                    <svg class="w-4 h-4" style="color:var(--navy)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="font-display font-bold text-navy text-base">Session Details</h4>
            </div>
            @foreach([['Academic Year Begins','April 15, 2026'],['Orientation Program','April 10–12, 2026'],['Office Hours','8:00 AM – 4:00 PM']] as [$k,$v])
            <div class="date-row">
                <span class="text-sm" style="color:#4B5563;font-family:'Plus Jakarta Sans',sans-serif">{{ $k }}</span>
                <span class="text-sm font-bold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $v }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
</section>

{{-- ══ FEE STRUCTURE ════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff" id="fees">
<div class="max-w-4xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-12 reveal">
        <div class="section-label justify-center">Transparent Pricing</div>
        <h2 class="section-title">Fee Structure</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>

    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-8 mb-6 reveal">
        <p class="text-gray-500 text-sm mb-8 leading-[1.85]" style="font-family:'Plus Jakarta Sans',sans-serif">
            We believe in providing quality education at affordable rates. Our fee structure is transparent and competitive, with provisions for scholarships and fee concessions.
        </p>
        <h4 class="font-display font-bold text-navy mb-5 text-sm">Annual Fee Structure (2026–27)</h4>
        @foreach(['Primary Level (1–5)','Secondary Level (6–10)','+2 Level (11–12)'] as $level)
        <div class="fee-row">
            <span class="text-sm text-gray-600" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $level }}</span>
            <a href="{{ route('contact.index') }}" class="text-sm font-bold text-navy hover:text-gold transition-colors" style="transition-timing-function:var(--ease-out)">Contact Office →</a>
        </div>
        @endforeach
        <p class="text-xs text-gray-400 mt-5" style="font-family:'Plus Jakarta Sans',sans-serif">*Includes tuition, library, sports, and laboratory fee. Transport and books are charged separately.</p>
    </div>

    <div class="rounded-xl p-5 text-sm border" style="background:rgba(201,162,39,0.07);border-color:rgba(201,162,39,0.2);font-family:'Plus Jakarta Sans',sans-serif;color:#4B5563">
        <strong style="color:var(--gold)">Scholarship Available:</strong> Merit-based scholarships and need-based financial assistance are available for eligible students.
        <a href="{{ route('contact.index') }}" class="font-semibold ml-1 hover:text-gold transition-colors" style="color:var(--navy)">Contact us for details →</a>
    </div>
</div>
</section>
@endif

{{-- ══ CTA ═══════════════════════════════════════════════════════════════ --}}
@if (($ctaSections ?? collect())->isNotEmpty())
    @foreach ($ctaSections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else
<section class="grand-cta py-28 text-white text-center"
    style="background:linear-gradient(140deg,#0D1B2E 0%,#111a30 50%,#0D1B2E 100%)"
    data-particle-1="rgba(255,255,255,0.1)" data-particle-2="rgba(201,162,39,0.35)">
    <canvas class="cta-canvas"></canvas>

    <div class="absolute -top-20 -left-20 w-80 h-80 border rounded-full pointer-events-none" style="border-color:rgba(255,255,255,0.04)"></div>
    <div class="absolute -bottom-20 -right-20 w-[440px] h-[440px] border rounded-full pointer-events-none" style="border-color:rgba(201,162,39,0.06)"></div>

    <div class="relative max-w-2xl mx-auto px-6 reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Come See Us</div>
        <h2 class="font-display font-bold text-white leading-tight mb-5 mt-2" style="font-size:clamp(2.2rem,5vw,3.8rem)">Visit Our Campus</h2>
        <p class="text-white/50 mb-12 leading-relaxed" style="font-size:15px;font-family:'Plus Jakarta Sans',sans-serif">
            Schedule a campus tour and see our facilities, meet our teachers, and experience the SSSS community first-hand.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="#form" class="btn-primary">Apply Online Now</a>
            <a href="{{ route('contact.index') }}" class="btn-ghost-white">Schedule a Visit</a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                e.target.querySelectorAll('.gold-bar').forEach(b => setTimeout(() => b.classList.add('visible'), 250));
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));

    document.querySelectorAll('.grand-cta').forEach(section => {
        const canvas = section.querySelector('.cta-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const c1 = section.dataset.particle1 || 'rgba(255,255,255,0.12)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.3)';
        let particles = [];
        function resize() { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; }
        window.addEventListener('resize', resize); resize();
        class Particle { constructor(){this.init();} init(){this.x=Math.random()*canvas.width;this.y=Math.random()*canvas.height;this.size=Math.random()*2+0.5;this.speedX=(Math.random()-.5)*.4;this.speedY=(Math.random()-.5)*.4;this.color=Math.random()>.5?c1:c2;} update(){this.x+=this.speedX;this.y+=this.speedY;if(this.x<0||this.x>canvas.width||this.y<0||this.y>canvas.height)this.init();} draw(){ctx.fillStyle=this.color;ctx.beginPath();ctx.arc(this.x,this.y,this.size,0,Math.PI*2);ctx.fill();} }
        for(let i=0;i<55;i++) particles.push(new Particle());
        (function animate(){ctx.clearRect(0,0,canvas.width,canvas.height);particles.forEach(p=>{p.update();p.draw();});requestAnimationFrame(animate);})();
    });
});
</script>
@endpush
